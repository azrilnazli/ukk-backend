<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\Video;
use App\Models\Company;
use App\Models\Tender;
use App\Models\TenderSubmission;
use App\Services\VideoService;

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

        // create video placeholder
        $this->video = new VideoService;
        $this->video->createProgressFile($video->id);
        $this->video->createDirectory($video->id);


        //save video->id to Proposal
        $proposal->video_id =  $video->id;
        $proposal->save();

        // JSON response
        return response([
            'id' => $proposal->id,
            'video_id' => $video->id,
        ]);
    }


    function get_tenders($type){
        $company = Company::query()
        ->where('user_id' , auth()->user()->id)
        ->first();
        //Log::info($company->is_approved);
        if($company->is_approved){
                    // list all proposals by user
                    $proposals = TenderSubmission::query()
                    ->with('tender')
                    ->where('user_id' , auth()->user()->id)
                    ->get();

                    if($type == 'SAMBUNG SIRI'){
                        // count total number for sambung siri
                        $total['sambung_siri'] = $proposals->where('tender.type','SAMBUNG SIRI')->count();
                        if( $total['sambung_siri'] > 1 ) {
                            return response(['title' => 'SAMBUNG SIRI ERROR', 'message' => 'Quota reached! ( only 1 proposal )'],422);
                        }
                    }

                    if($type == 'SWASTA'){

                        $total['swasta'] = $proposals->where('tender.type','SWASTA')->count();
                        if($total['swasta'] > 2 ) {
                            return response(['title' => 'SWASTA ERROR', 'message' => 'Quota Reached! ( only 2 proposals )'],422);
                        }
                    }

                    // display tender
                    $tenders = Tender::query()
                    ->where(['type' =>  $type ])
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

                } else {
                    return response(['title' => 'Status Error', 'message' => 'Restricted area!. You are not eligible to participate.'],422);
                }


    }

    // function sambung_siri(){

    //     // check if user.company.is_approved = TRUE
    //     //return $this->checkIsApproved();

    //     // display tender
    //     $tenders = Tender::query()
    //                 ->where(['type' =>  "SAMBUNG SIRI" ])
    //                 ->get();

    //     if( !$tenders->isEmpty() ){
    //         $message = [
    //             'exists' => true,
    //             'tenders' => $tenders,
    //         ];

    //     } else {
    //         $message = [
    //             'exists' => false,
    //         ];
    //     }
    //     return response($message);
    // }

    // function swasta(){
    //     // check if user.company.is_approved = TRUE
    //     return $this->checkIsApproved();

    //     if($company->is_approved != 1) return response(['title' => 'Status Error', 'message' => 'Restricted area!. You are not eligible to participate.'],422);

    //     $tenders = Tender::query()
    //                 ->where(['type' =>  "SWASTA" ])
    //                 ->get();

    //     if( !$tenders->isEmpty() ){
    //         $message = [
    //             'exists' => true,
    //             'tenders' => $tenders,
    //         ];

    //     } else {
    //         $message = [
    //             'exists' => false,
    //         ];
    //     }
    //     return response($message);
    // }

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
