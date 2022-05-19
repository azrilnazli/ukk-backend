<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\Video;
use App\Models\Tender;
use App\Models\TenderSubmission;

// Form Validation
use App\Http\Requests\Tender\StoreTenderSubmissionRequest;


use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenderController extends Controller
{

    function __construct(){ }

    function show_proposal($tender_id){
        $proposal = TenderSubmission::query()
                    ->where(
                        [
                            'user_id' =>  auth()->user()->id,
                            'tender_id'  => $tender_id
                        ])
                    ->first();

        if( $proposal ){
            $message = [
                'exists' => true,
                'proposal' => $proposal,
            ];
 
        } else {          
            $message = [
                'exists' => false,
            ];
        }
        return response($message); 
    }
    
    function update_proposal(StoreTenderSubmissionRequest $request){

        // tender submission
        $proposal = TenderSubmission::firstOrNew(
            [
                'user_id' => auth()->user()->id,
                'tender_id' =>  $request->tender_id
            ]
        );

        $proposal->user_id = auth()->user()->id;
        $proposal->tender_id =  $request->tender_id;
        $proposal->theme = $request->theme;
        $proposal->genre = $request->genre;
        $proposal->concept = $request->concept;
        $proposal->synopsis = $request->synopsis;
        $proposal->save();

        // create video placeholder
        $video = Video::firstOrNew([
            'user_id' => auth()->user()->id ,
            'tender_id' =>  $request->tender_id,
            'tender_submission_id' => $proposal->id
        ]);
 
        $video->user_id = auth()->user()->id;
        $video->tender_submission_id =  $proposal->id;
        $video->tender_id =  $request->tender_id;
        
        $video->save();

        //save video->id to Proposal
        $proposal->video_id =  $video->id;
        $proposal->save();
 
        // JSON response
        return response([
            'id' => $proposal->id,
            'video_id' => $video->id,
        ]);
    }

    function sambung_siri(){

        // check if user.company.is_approved = TRUE
        $is_approved =  auth()->user()->company->is_approved;
        $message = [
            'exists' => false,
        ];
        if($is_approved == FALSE) return response(['title' => 'Status Error', 'message' => 'Restricted area!. You are not eligible to participate.'],422);


        // display tender
        $tenders = Tender::query()
                    ->where(['type' =>  "SAMBUNG SIRI" ])
                    ->get();

        if( !$tenders->isEmpty() ){
            $message = [
                'exists' => true,
                'is_approved' => $is_approved,
                'tenders' => $tenders,
            ];
 
        } else {          
            $message = [
                'exists' => false,
            ];
        }
        return response($message);
    }

    function swasta(){
        // check if user.company.is_approved = TRUE
        $is_approved =  auth()->user()->company->is_approved;
        $message = [
            'exists' => false,
        ];
        if($is_approved == FALSE) return response(['title' => 'Status Error', 'message' => 'Restricted area!. You are not eligible to participate.'],422);


                
        $tenders = Tender::query()
                    ->where(['type' =>  "SWASTA" ])
                    ->get();

        if( !$tenders->isEmpty() ){
            $message = [
                'exists' => true,
                'tenders' => $tenders,
            ];
 
        } else {          
            $message = [
                'exists' => false,
            ];
        }
        return response($message);
    }

    function show($id){
        $tender = Tender::query()
        ->select('*')
        ->where('id', $id)
        ->first();

        if($tender){
            $message = [
                'exists' => true,
                'tender' => $tender,
            ];
        }else{
            $message = [
                'exists' => false,
            ];
        }
                
        return response($message);
    }

}
