<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\Company;
use App\Models\Comment;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Form Validation
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
                'category_id'   => 6, // proposal sambung siri
                'title'     => 'Proposal Video',
                'synopsis'  => 'Video Synopsis',
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
    
            // send video for processing
            $this->dispatch(new ConvertVideoQueue($video));
        }


        return response([
            'uploaded' => true,
            'id' => $company->id,
        ]);
    }

}
