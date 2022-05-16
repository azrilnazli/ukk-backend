<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;


use App\Models\Video;
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


class CompanyProposalController extends Controller
{

    function __construct()
    {
        $this->video = new VideoService;
    }
    
     // only accept PDF
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
            $uploading_duration = $this->video->upload($request['file']);
            

            $data = [
                'user_id'       => Auth::user()->id,
                'tender_id'       => $request->tender_id,
                'tender_submission_id'  => $request->proposal_id,
                'filesize'  => $request->file('file')->getSize(),
                'original_filename'  => $request->file('file')->getClientOriginalName(),
                'uploading_duration' => $uploading_duration,
                'is_processing' => true,
      
             ];

            $this->video->api_store($data, Auth::user()->id );

            $video = Video::firstOrNew(['user_id' =>  Auth::user()->id ]);
     
            $this->video->createProgressFile($video->id);
            $this->video->createDirectory($video->id);

            $path = basename($request->file('file')->getPathName() );
            //Log::info($path);
            $this->video->api_moveVideoToStorage($path,$video->id);
    
            // save max height to db    
            $video->max_resolution =  $this->video->getMaxResolution($video->id);
            $video->save();

            // save video_id in TenderSubmission
            $proposal =   TenderSubmission::find($request->proposal_id);
            $proposal->video_id = $video->id;
            $proposal->save();
    
            // send video for processing
            $this->dispatch(new ConvertVideoQueue($video));
        }


        return response([
            'uploaded' => true,
            'video_id' => $video->id,
        ]);
    }

    function get_video($proposal_id){
       
        $proposal = TenderSubmission::query()
                    ->where(['id' =>  $proposal_id ])
                    ->first();

        if( $proposal->video_id ){
            $message = [
                'exists' => true,
                'video_id' => $proposal->video_id,
            ];
 
        } else {          
            $message = [
                'exists' => 'false',
            ];
        }
        return response($message);
    }

    function upload_pdf(UploadPDFRequest $request){
        if($request->hasFile('file')){ // if exists
         
            // move to folder
            $request->file('file')
            ->storeAs(
                $request->proposal_id, // path within disk's root
                'proposal.pdf', // filename
                'proposals' // disk
            );

            $message = [
                'exists' => 'false',
            ];

            if(Storage::disk('proposals')->exists($request->proposal_id) .'/proposal.pdf'){
                Log::info('file exists');
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
                'exists' => 'false',
            ];
        }
        return response($message);
    }

}
