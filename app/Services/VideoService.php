<?php
namespace App\Services;

use App\Models\Video;
use App\Models\TenderSubmission;
use App\Models\FailedJob;
use App\Models\Category;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;
use Image;
use File;
use Auth;
use DB;
use Config;
use Log;

use FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

class VideoService {

    public function __constructor()
    {

    }

    public function paginate($item = null)
    {
        return Video::query()
            ->where('duration','!=', 0)
            ->orderBy('updated_at','desc')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('videos.index'));
    }

    public function failed($item = null)
    {
        return Video::query()
            ->whereHas('user.company', fn($query) =>
                $query->where('is_approved', true)
                )
            ->where('is_ready','=', 0)
            ->orWhere('duration','=', 0)
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('videos.failed'));
    }

    public function getCategories()
    {
        return Category::orderBy('title','ASC')->pluck('title', 'id');
    }

    public function upload($file)
    {
        // move to temp folder
        $start_time = microtime(true);

        Storage::disk('uploads')->putFileAs('', $file, $filename = basename($file->getPathName()));

        // End the clock time in seconds
        $end_time = microtime(true);

        // Calculate the script execution time
        return $uploading_duration = ($end_time - $start_time);
    }

    public function getAllowedMime()
    {
        return array('mimetypes:application/octet-stream,video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi');
    }

    public function validate($request)
    {

        return Validator::make(
            $request->all(),
            [
                'file' => $this->getAllowedMime()
            ],
        ); // make

    }

    public function getErrorMessages($validator)
    {
        return array_map(
            function($fieldErrors)
            {
                return $fieldErrors[0];
                //return $mime;
            },
            $validator->getMessageBag()->toArray()
        );
    }

    public function store($request, $user_id)
    {
        return Video::create([
            'user_id'       => $user_id,
            'category_id'   => $request['category_id'],
            'title'     => $request['title'],
            'synopsis'  => $request['synopsis'],
            'filesize'  => $request->session()->pull('filesize'),
            'original_filename'  => $request->session()->pull('original_filename'),
            'uploading_duration' => $request['uploading_duration'],
            'processing' => 1 // mark as start processing
        ]);
    }

    public function api_store($request, $company_id)
    {
        // return Video::create([
        //     'user_id'       => $user_id,
        //     'category_id'   => $request['category_id'],
        //     'title'     => $request['title'],
        //     'synopsis'  => $request['synopsis'],
        //     'filesize'  => $request['filesize'],
        //     'original_filename'  => $request['original_filename'],
        //     'uploading_duration' => $request['uploading_duration'],
        //     'processing' => 1 // mark as start processing
        // ]);


        $video = Video::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'company_id' =>  $request['company_id'] ,
            'tender_submission_id' => $request['tender_submission_id']
        ]);

        $video->tender_submission_id =  $request['tender_submission_id'];
        $video->original_filename = $request['original_filename'];
        $video->uploading_duration =  $request['uploading_duration'];
        $video->filesize =  $request['filesize'];
        $video->is_ready =  0;
        $video->is_processing = 1;
        $video->duration =  0;

        $video->save();
        //Log::info($video);
        return $video;

    }

    public function createProgressFile($id)
    {

        // conversion progress file
        $profiles = collect(Config::get('laravel-ffmpeg.profiles'));
        $profiles->each( function($item, $key) use ($id){
            Storage::disk('assets')->put( $id . "/progress_$key.txt" , 0);
        });

        // progress_all.txt starts with 0
        Storage::disk('assets')->put( $id . "/progress_all.txt" , 0);
    }

    public function createDirectory($id)
    {

        // create folder for handling assets for private and public
        $collection = collect([
            ['disk' => 'assets',    'folders' => ['mp4','secrets'] ],
            ['disk' => 'streaming', 'folders' => ['m3u8','images', 'thumbnails'] ],
        ]);

        $disks = $collection->pluck('disk')->each(function ($item,$key) use ($collection, $id) {
            // create master folder
            Storage::disk($item)->makeDirectory( $id ); // make primary folder
            // iterate using disk value from pluck() above
            $collection->where('disk', $item)->each( function ($item, $key) use ($collection, $id) {
                // create folders
                foreach( $item['folders'] as $folder){
                    Storage::disk($item['disk'])->makeDirectory( $id . '/' . $folder);
                }
            });
        });
    }

    public function moveVideoToStorage($request, $id)
    {
        $file = Storage::disk('uploads')->path($request->session()->pull('uploaded_video'));
        $dest = Storage::disk('assets')->path($id . '/original.mp4');
        File::move($file,$dest);
    }

    public function api_moveVideoToStorage($path, $id)
    {
        $file = Storage::disk('uploads')->path($path);
        $dest = Storage::disk('assets')->path($id . '/original.mp4');
        File::move($file,$dest);
    }

    public function getMaxResolution($id)
    {
        // get video width
        $media = FFMpeg::fromDisk('assets')
        ->open( $id . '/original.mp4')
        ->getVideoStream()
        ->getDimensions();

        // use this to calculate max resolution to encode
        return  $media->getHeight();
    }

    public function ffprobe($id,$info)
    {
        //Storage::disk('assets')->put($filename="test.txt", 'hello world');
        $file = Storage::disk('assets')->path( $id .'/original.mp4');
        $ffprobe = FFMpeg\FFProbe::create();

        return $ffprobe
                ->format($file) // extracts file informations
                ->get($info);
    }

    public function getImage($id,$poster)
    {
        if(Storage::disk('streaming')->exists($id . '/thumbnails/' . $poster)){
            return Storage::disk('streaming')->url($id . '/thumbnails/' . $poster);
        } else {
            return FALSE;
        }
    }

    public function delete($id)
    {

        // $video->user->proposal->synopsis
        // set video_id = 0 in TenderSubmission
        //$video = Video::find($id)->first();
        //$proposal_id = $video->tender_submission_id;
        //$proposal = TenderSubmission::find($proposal_id);
        //$proposal->video_id = 0;
        //$proposal->save();

        if( Video::where('id',$id)->delete() ){
            Storage::disk('assets')->deleteDirectory( $id ); // private dir
            Storage::disk('streaming')->deleteDirectory( $id ); // public dir
        }
    }



}
