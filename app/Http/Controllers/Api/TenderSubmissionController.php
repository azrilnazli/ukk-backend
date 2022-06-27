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
        $proposal = TenderSubmission::create($request->except(['_token','_method']));
        $proposal->company_id = $company->id;
        $proposal->save();

        // // create video instance
        // $video = Video::firstOrNew([
        //     'user_id' => auth()->user()->id ,
        //     'tender_id' =>  $request->tender_id,
        //     'tender_submission_id' => $proposal->id
        // ]);

        // $video->user_id = auth()->user()->id;
        // $video->tender_submission_id =  $proposal->id;
        // $video->tender_id =  $request->tender_id;
        // $video->save();

        // // create video placeholder
        // $this->video = new VideoService;
        // $this->video->createProgressFile($video->id);
        // $this->video->createDirectory($video->id);

        // //save video->id to Proposal
        // $proposal->video_id =  $video->id;
        // $proposal->save();

        // JSON response
        return response([
            'id' => $proposal->id,
            'video_id' => $video->id,
        ]);
    }
}
