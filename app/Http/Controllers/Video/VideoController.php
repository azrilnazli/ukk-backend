<?php
namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\FailedJob;
use App\Models\Category;
use App\Http\Requests\Video\StoreVideoRequest;
use App\Http\Requests\Video\UpdateVideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;
use Image;
use File;
use Auth;
use DB;
use Config;
use Log;

use App\Jobs\ConvertVideo;
use App\Jobs\ConvertVideoQueue;


use FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

use App\Services\VideoService;

class VideoController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:video-list|video-create|video-edit|video-delete', ['only' => ['index','show']]);
        $this->middleware('permission:video-create', ['only' => ['create','store']]);
        $this->middleware('permission:video-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:video-delete', ['only' => ['destroy']]);

        $this->video = new VideoService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data = Video::orderBy('id','desc')->paginate(7)->setPath('videos');
        $data = $this->video->paginate(25);
        return view('videos.index',compact(['data']));
    }

    public function failed()
    {
        //$data = Video::orderBy('id','desc')->paginate(7)->setPath('videos');
        $data = $this->video->failed(25);
        return view('videos.failed',compact(['data']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->video->getCategories();
        return view('videos.create')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVideoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request)
    {
        // create DB entry
        $video = $this->video->store($request, Auth::user()->id );
        $this->video->createProgressFile($video->id);
        $this->video->createDirectory($video->id);
        $this->video->moveVideoToStorage($request,$video->id);

        // save max height to db
        $video->max_resolution =  $this->video->getMaxResolution($video->id);
        $video->save();

        // send video for processing
        $this->dispatch(new ConvertVideoQueue($video));

        // redirect
        return redirect()->route('videos.status', $video->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //$extra['format'] =  $this->video->ffprobe($video->id,'format_long_name');
        $extra['format'] =  null;
        return view('videos.show',compact(['video','extra']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $poster = null;
        //$data = Video::find($video->id);
        $categories = $this->video->getCategories();
        $poster[1] = $this->video->getImage($video->id,'potrait.jpg');
        $poster[2] = $this->video->getImage($video->id,'poster.jpg');

        return view('videos.edit',compact(['video','categories','poster']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideoRequest  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {

        $video->update([
            'category_id'   => $request['category_id'],
            'title'         => $request['title'],
            'synopsis'      => $request['synopsis'],
        ]);

        // user upload poster potrait
        if($request->hasFile('poster-1')){

            $request->file('poster-1')->storeAs(
                $video->id,
                '/thumbnails/poster-1.jpg',
                'streaming');

            $file = Storage::disk('streaming')->path($video->id . '/thumbnails/poster-1.jpg');
            $dest = Storage::disk('streaming')->path($video->id . '/thumbnails/potrait.jpg');

            // resize
            $poster = Image::make($file);
            $poster->resize(185,278);
            $poster->save($dest);
            //
        }

        // user upload poster landscape
        if($request->hasFile('poster-2')){

            $request->file('poster-2')->storeAs(
                $video->id,
                '/thumbnails/poster-2.jpg',
                'streaming');

            $file = Storage::disk('streaming')->path($video->id . '/thumbnails/poster-2.jpg');
            $dest = Storage::disk('streaming')->path($video->id . '/thumbnails/poster.jpg');

            // resize
            $poster = Image::make($file);
            $poster->resize(1280,720);
            $poster->save($dest);

        }

        return redirect()->route('videos.show', $video->id)->with('success','Video updated.');
        //$url = $request->only('redirects_to');
        //return redirect()->to( $url['redirects_to'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $this->video->delete($video->id);
        return redirect('videos')->with('success','video ' . $video->name . ' successfully removed.');
    }

    // user upload video for first time
    // put video in temp dir
    // should clear unprocessed video using cron job
    // Storage::disk('uploads')
    public function store_video(Request $request)
    {
        // user upload video
        if($request->hasFile('file'))
        {
            // form validation
            $validator = $this->video->validate($request);

            // fails
            if ($validator->fails())
            {
                // json return data
                $data = [
                    'status' => 'error',
                    'message' => $this->video->getErrorMessages($validator)
                ];

                return response()->json($data); // Return OK to user's browser

            // validation is success
            } else {

                $file =  $request['file']; // uploaded video

                // upload to temp dir
                $uploading_duration = $this->video->upload($request['file']);

                // assign $value = $key
                $session = array(
                    'uploaded_video' =>  basename( $file->getPathName() ),
                    'original_filename' =>  $file->getClientOriginalName(),
                    'filesize' => $file->getSize(),
                    'uploading_duration' => $uploading_duration
                );

                // collect, iterate and register to session
                collect($session)
                ->each( function($value,$key) use ($request) {
                    $request->session()->put($key, $value );
                });

                // json return data
                $data = [
                    'status'  => 'success',
                    'path'    => $file->getPathName(), // to be used for next submitted form
                    'message' => 'success',
                ];

            }

            return response()->json($data); // Return OK to user's browser
        }
    }


    public function status(Video $video)
    {
        // from config
        $profiles = collect(Config::get('laravel-ffmpeg.profiles'))->all();
        // todo need to compare with max_resolution value from DB
        $quality['max'] = Config::get('laravel-ffmpeg.max');

        return view('videos.status',compact(['video','profiles','quality']    ));

    }

    // action for ajax status for video encoding process
    // read file generated by VideoQueueJob
    // Ajax will read that file
    // will become progress indicator in real time
    public function progress(Video $video)
    {

        # check failed_jobs table to check error while encoding
        $count = FailedJob::where('uuid', $video->job_id)->count();

        if($count == 0 )
        {
            $profiles = collect(Config::get('laravel-ffmpeg.profiles')); // read from config folder

            // todo need to compare with max_resolution value from DB

            $data = $profiles->mapWithKeys(function($item, $key) use ($video) { // iterate
               // return with customised key => value for JQuery JSON
               return [ "progress_$key" =>  Storage::disk('assets')->get( $video->id . "/progress_$key.txt" ) ];
            })->all();
            // append
            $data['success'] = TRUE;

        } else {

            $data = [
                'success'  => FALSE,
                'message' => 'error'
            ];
        }

        // return to JQuery requests
        return response()->json($data);
    }

    public function conversion_progress(Video $video)
    {
        Log::info($video);

        if($video->is_processing == 1){
            // check video status
            $progress = Storage::disk('assets')->get( $video->id . "/progress_all.txt" );

            $status = true;
            if($progress == 100){
                $status = false;
            }
        } else {
            $progress = 0;
            $status = false;
        }

        return response([
            'converting' => $status,
            'progress' => $progress,
        ]);

    }

    public function is_playable(Video $video)
    {

        $status = false;
        if($video->is_ready == TRUE){
            $status = true;
        }
        return response([
            'is_playable' => $status,
        ]);
    }

    public function delayed_redirect(Video $video){
        sleep(3);
        return redirect()->route('videos.edit', $video->id);
    }


    public function encoding_status(){

        return view('videos.encoding_status');
    }

}
