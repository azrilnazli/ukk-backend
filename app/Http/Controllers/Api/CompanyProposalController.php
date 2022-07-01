<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\Company;
use App\Models\Comment;
use App\Models\TenderSubmission;


use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Form Validation
use App\Http\Requests\Company\UploadPDFRequest;
use App\Http\Requests\Company\CompanyRequest;
use App\Http\Requests\Company\StoreVideoRequest;
use App\Services\VideoService;

use App\Jobs\ConvertVideo;
use App\Jobs\ConvertVideoQueue;


use FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use File;
use Illuminate\Filesystem\Filesystem;


use Route;


class CompanyProposalController extends Controller
{

    function __construct()
    {
        $this->video = new VideoService;
    }

    static function routes(){
        // company proposals
        Route::get('/proposal/my_proposal', [CompanyProposalController::class, 'my_proposal']);

        Route::get('/proposal/{tenderSubmission}', [CompanyProposalController::class, 'show']);

        Route::post('/proposal/upload_video', [CompanyProposalController::class, 'upload_video']);
        Route::get('/proposal/{proposal_id}/get_video', [CompanyProposalController::class, 'get_video']);
        Route::post('/proposal/upload_pdf', [CompanyProposalController::class, 'upload_pdf']);
        Route::get('/proposal/{proposal_id}/get_pdf', [CompanyProposalController::class, 'get_pdf']);
        Route::post('/proposal/destroy', [CompanyProposalController::class, 'destroy']);
    }

    function show(TenderSubmission $tenderSubmission){

        $message = [
            'status' => true,
            'tender_submission' => $tenderSubmission,
        ];

        return response($message);
    }

    public function destroy(Request $request){

        // disable
        //return response(['title' => 'System Error', 'message' => 'You can\'t delete this data.'],422);

        $company = Company::query()
                    ->where('user_id' , auth()->user()->id)
                    ->first();

        // get collection
        $proposal = TenderSubmission::query()
                        ->where('id',$request->proposal_id)
                        ->where('company_id', $company->id)
                        ->first();

        // check ownership
        if($proposal == null ) return response(['title' => 'System Error', 'message' => 'You can\'t delete this data.'],422);

        // destroy video DB
        if($proposal->has('video')){
            if($proposal->video){
                $video = new VideoService;
                $video->delete($proposal->video->id);
            }
        }


        // destroy folder
        Storage::disk('proposals')->deleteDirectory( $request->proposal_id ); // proposal dir
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/proposals/' . $request->proposal_id);

        // destroy proposal
        if( $proposal->delete() ){

            return response([
                'proposal_id' => $request->proposal_id,
                'destroyed' => true,
            ]);
        } else {
            return response(['title' => 'System Error', 'message' => 'You can\'t delete this data.'],422);
        }

    }

    public function my_proposal(){
        // check if user's company is_approved = trye
        $company = Company::query()
                    ->where('user_id' , auth()->user()->id)
                    ->first();


        //Log::info($company->is_approved);
        //if($company->is_approved == 1 ){
        if( $company ){

             // list
             $proposals = TenderSubmission::query()
                            ->with('tender.tender_detail','video')
                            ->where('company_id' , $company->id)
                            ->orderBy('id','DESC')
                            ->get();

            if (!$proposals->isEmpty()) {
                return response([
                    'uploaded' => true,
                    'proposals' => $proposals,
                ]);
            } else {
                return response([
                    'uploaded' => false,
                ]);
            }

        } else {
            return response(
                [
                    'uploaded' => false,
                    'title' => 'Error',
                    'message' => 'Please complete your Company Profile in My Account.'
                ]
                ,422);
        }
    }

    // only accept VIDEO
    public function upload_video(StoreVideoRequest $request){
        // log to laravel.log
        //Log::info($request);

        // get folder ID ( User hasOne Company)
        $company = DB::table('companies')
                    // select required fields
                    ->select(
                        DB::raw('companies.id'),
                    )
                    // belongs to who ?
                    ->where('user_id', auth()->user()->id) // user_id
                    // get the Collection
                    ->first();

        //Log::info($company->id);
        if($request->hasFile('file')){ // if exists

            //  // upload to temp dir disk('uploads')
            // $uploading_duration = $this->video->upload($request->file('file')); // tested OK


            $file =  $request['file']; // uploaded video

            // upload to temp dir
            $this->video->upload($request['file']);

            //Log::info($request);
            //Log::info(gmdate("Y-m-d H:i:s"));
            $start_time = strtotime($request['start_time']);
            $end_time =   strtotime(gmdate("Y-m-d H:i:s"));

            $uploading_duration =  round($end_time - $start_time); // in microtime
            //Log::info($end_time);
            //Log::info($start_time);
            $data = [
                'user_id'       => Auth::user()->id,
                'company_id' =>  $company->id,
                'tender_submission_id'  => $request->tender_submission_id,
                'filesize'  => $request->file('file')->getSize(),
                'original_filename'  => $request->file('file')->getClientOriginalName(),
                'uploading_duration' => $uploading_duration,
             ];

            $video = $this->video->api_store($data, Auth::user()->id );
            $this->video->createProgressFile($video->id);
            $this->video->createDirectory($video->id);

            $path = basename($request->file('file')->getPathName() );
            //Log::info($path);
            $this->video->api_moveVideoToStorage($path,$video->id);

            // save max height to db
            $video->max_resolution =  $this->video->getMaxResolution($video->id);
            $video->save();

            // save video_id in TenderSubmission
            // $proposal =   TenderSubmission::find($request->proposal_id);
            // Log::info($video->id);

            // $proposal->video_id = $video->id;
            // $proposal->save();

            // send video for processing
            $this->dispatch(new ConvertVideoQueue($video));
        }

        return response([
            'uploaded' => true, // use this flag
            'video_id' => $video->id,
        ]);
    }

    function get_video($proposal_id){

        $proposal = TenderSubmission::query()
                    ->with('video')
                    ->has('video')
                    ->where(['id' =>  $proposal_id ])
                    ->first();
        // check if video was uploaded

        // get video_id

        // check if video is_ready
        //Log::info($proposal);

        // by default video_is is null
        if($proposal){
           // if( $proposal->video->is_ready || $proposal->video->is_processing ){
                $message = [
                    'exists' => true,
                    'is_ready' => $proposal->video->is_ready ? true : false,
                    'is_processing' => $proposal->video->is_processing ? true : false,
                    'video_id' => $proposal->video->id,
                ];
           // }
        } else {

            $message = [
                'exists' => false,
            ];
        }
        return response($message);
    }

    function upload_pdf(UploadPDFRequest $request){

        // should check proposal owned by user

        // copy the file
        if($request->hasFile('file')){ // if exists
            // move to folder
            $request->file('file')
            ->storeAs(
                $request->proposal_id, // path within disk's root
                'proposal.pdf', // filename
                'proposals' // disk
            );

            $message = [
                'exists' => false,
            ];

            if(Storage::disk('proposals')->exists($request->proposal_id) .'/proposal.pdf'){
                //Log::info('file exists');
                $uploaded = true;

                DB::table('tender_submissions')
                ->where('id', $request->proposal_id)
                ->update(['is_pdf_cert_uploaded' => true]);

                $message = [
                    'exists' => true,
                ];
            }

            return response($message);
        }

    }

    function get_pdf($proposal_id){

        $proposal = TenderSubmission::query()
                    ->where(['id' =>  $proposal_id ])
                    ->first();

        if( $proposal->is_pdf_cert_uploaded == TRUE ){
            $message = [
                'exists' => true,
                'path' => "/storage/proposals/" . $proposal_id . "/proposal.pdf"
            ];

        } else {
            $message = [
                'exists' => false,
            ];
        }
        return response($message);
    }

}
