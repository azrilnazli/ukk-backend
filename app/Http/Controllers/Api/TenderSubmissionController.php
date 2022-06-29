<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\TenderSubmission;

// Form Validation
use App\Http\Requests\Tender\TenderSubmission\StoreRequest;

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
    }

    // pembekal request show tender
    function show(TenderSubmission $tenderSubmission){
        // check pembekal status ( CompanyApproval=> is_approved)

        // JSON Response
        return response([
            'status' => true, // return as boolean
            'message' => $tenderSubmission->id,
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


        // // create video instance
        // $video = \App\Models\Video::firstOrNew([
        //     'user_id' => auth()->user()->id ,
        //     'company_id' =>  $company->id,
        //     'tender_submission_id' => $tenderSubmission->id
        // ]);

        // $video->user_id = auth()->user()->id;
        // $video->tender_submission_id =  $tenderSubmission->id;
        // $video->tender_id =  $request->tender_id;
        // $video->save();

        // // create video placeholder
        // $this->video = new \App\Services\VideoService;
        // $this->video->createProgressFile($video->id);
        // $this->video->createDirectory($video->id);

        // //save video->id to Proposal
        // $tenderSubmission->video_id =  $video->id;
        // $tenderSubmission->save();


    }
}
