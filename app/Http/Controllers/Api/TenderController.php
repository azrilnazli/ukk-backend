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

use Route;

class TenderController extends Controller
{

    function __construct(){ }

    static function routes(){
        Route::get('/tenders/sambung_siri', [TenderController::class, 'sambung_siri']);
        Route::get('/tenders/swasta', [TenderController::class, 'swasta']);
        //Route::get('/tenders/{type}/get_tenders', [TenderController::class, 'get_tenders']);
        Route::get('/tenders/{tenderDetail}/get_tenders', [TenderController::class, 'getTenders']);
        Route::get('/tender/{id}', [TenderController::class, 'show']);
        Route::post('/tender/update_proposal', [TenderController::class, 'update_proposal']);
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

    function getTenders(\App\Models\TenderDetail $tenderDetail){

        // check if Company exists ?
        $company = \App\Models\Company::query()
                    ->where('user_id' , auth()->user()->id)
                    ->first();
        if(!$company){
            return response(
                [
                    'status' => false,
                    'title' => 'COMPANY ERROR',
                    'message' => 'Your company was not exist.'
                ]
                ,422);
        }


        // check if Company was Approved for TenderDetail
        $result = \App\Models\CompanyApproval::query()
                            ->where('company_id',$company->id)
                            ->where('tender_detail_id',$tenderDetail->id)
                            ->where('is_approved', true)
                            ->first();

        if(!$result){
            return response(
                [
                    'status' => false,
                    'title' => 'APPROVAL ERROR',
                    'message' => 'Your company was not approved for this tender.'
                ]
                ,422);
        }

        // check if Company TenderSubmission count exceed quota
        $max = $tenderDetail->max;
        // $applied = \App\Models\Company::query()
        //             ->where('user_id' , auth()->user()->id)
        //             ->whereHas('tender_submissions', function($query) use ($tenderDetail) {
        //                 $query->where('tender_detail_id', $tenderDetail->id);
        //             })
        //             ->get()
        //             ->count();

         $applied = \App\Models\Company::query()
                    ->select('id')
                    ->where('user_id' , auth()->user()->id)
                    ->has('tender_submissions')
                    ->withCount([
                        'tender_submissions' => function ($q) use ($tenderDetail) {
                                                    $q->where('tender_detail_id', $tenderDetail->id);
                                                }
                    ])
                    ->first();

        if($applied){
            // calculate if equal or more
            if($applied->tender_submissions_count >= $max){
            //    if(true){
                return response(
                    [
                        'status' => false,
                        'title' => 'TENDER QUOTA ERROR',
                        'message' => 'Your have exceeded the tender quota.'
                    ]
                    ,422);
            }
        }

        // all checks passed, now return the tenders
        $tenders = \App\Models\Tender::query()
                        ->with(['languages','tender_detail'])
                        ->where('tender_detail_id' , $tenderDetail->id)
                        ->get();

        return response([
            'status' => true, // return as boolean
            'tenders' => $tenders,
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
