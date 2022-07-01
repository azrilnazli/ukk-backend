<?php

namespace App\Http\Controllers\Tender;

use App\Models\TenderSubmission;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Services\TenderSubmissionService;
use Route;


class TenderSubmissionController extends Controller
{
    var $tender_submission;

    function __construct()
    {
        $this->middleware(
             'permission:tender-submission-list|tender-submission-create|tender-submission-edit|tender-submission-delete',
             ['only' => ['index','show']]
        );

        $this->middleware('permission:tender-submission--create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-submission--edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:tender-submission--delete', ['only' => ['destroy']]);

        $this->tender = new TenderSubmissionService;
    }

    static function routes()
    {
        Route::get('/tender_submissions/search', [TenderSubmissionController::class, 'search'])->name('tender_submissions.search');
        Route::resource('tender_submissions', TenderSubmissionController::class );
    }

    public function index()
    {
        $proposals = $this->tender->paginate();
        return view('tender_submissions.index')->with(compact('proposals'));
    }

    public function search(Request $request){

        $proposals = $this->tender->search($request);
        return view('tender_submissions.index')->with(compact('proposals'));
    }

    // TenderProgrammeCode $tenderProgrammeCode
    public function show(TenderSubmission $tenderSubmission)
    {
        $unwanted = ['id','is_video','user_id','video_id','tender_id','company_id','tender_detail_id','created_at','updated_at','is_scoring_completed','is_verification_completed','is_pdf_cert_uploaded','added_by'];
        $columns = $tenderSubmission->getTableColumns();
        $fields = array_diff($columns,$unwanted);


        return view('tender_submissions.show')->with(compact('tenderSubmission','fields'));
    }


}
