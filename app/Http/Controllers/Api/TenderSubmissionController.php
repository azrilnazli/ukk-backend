<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\TenderSubmission;

// Form Validation
use App\Http\Requests\Tender\TenderSubmission\StoreRequest;
use App\Http\Requests\Tender\TenderSubmission\UpdateRequest;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;

class TenderSubmissionController extends Controller
{

    function __construct(){ }

    static function routes(){
        Route::get('/tender-submissions/{tenderSubmission}', [TenderSubmissionController::class, 'show']);
        Route::post('/tender-submissions/store', [TenderSubmissionController::class, 'store']);
        Route::post('/tender-submissions/{TenderSubmission}/edit', [TenderSubmissionController::class,'update']);
    }

    function show(TenderSubmission $tenderSubmission){

        // check if logged user is owner

        // JSON Response
        return response([
            'status' =>  $tenderSubmission ? true : false, // return as boolean
            'tender_submission' => $tenderSubmission,
        ]);
    }


    // pembekal apply tender
    function store(StoreRequest $request){
        // get Company Data
        $company = \App\Models\Company::where('user_id', auth()->user()->id )->first();

        // Create new
        $tenderSubmission = TenderSubmission::create($request->except(['_token','_method']));
        $tenderSubmission->company_id = $company->id;

        $proposal = TenderSubmission::with('tender.tender_detail')->find($tenderSubmission->id);
        $tenderSubmission->tender_detail_id = $proposal->tender->tender_detail->id;

        if( $tenderSubmission->save() ){

            // JSON response
            return response([
                'status' => true,
                'message' => 'Your application was successful.',
                'tender_submission_id' => $tenderSubmission->id
            ],200);

        }

        // JSON response
        return response([
            'status' => false,
            'message' => 'Server error.'
        ],423);

    }

    function update(UpdateRequest $request, $tenderSubmissionId){

        // get Company Data
        $company = \App\Models\Company::where('user_id', auth()->user()->id )->first();

        //check if logged user is owner
        $check = TenderSubmission::query()
                        ->where('id',$tenderSubmissionId)
                        ->where('company_id', $company->id)
                        ->first();
        if(!$check){
            // JSON Response
            return response([
                'status' => false, // return as boolean
                'message' => 'Invalid data.'
            ],423);
        }


        $proposal = TenderSubmission::find($tenderSubmissionId);
        if(!$proposal){
            // JSON Response
            return response([
                'status' => false, // return as boolean
                'message' => 'Data not found.' . $proposal->id
            ],423);
        }

        // now save the data
        if($proposal->update($request->except(['_token','_method']))){
            // JSON Response
            return response([
                'status' => true, // return as boolean
                'message' => 'Your proposal was updated.'
            ],200);
        } else {
            // JSON Response
            return response([
                'status' => false, // return as boolean
                'message' => 'Cannot save data.'
            ],423);
        }
    }
}
