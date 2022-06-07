<?php

namespace App\Http\Controllers\Tender;

use App\Models\TenderSubmission;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Services\TenderSubmissionService;


class TenderSubmissionController extends Controller
{
    var $tender_submission;

    function __construct()
    {
         $this->middleware('permission:tender-list|Tender-create|Tender-edit|Tender-delete', ['only' => ['index','show']]);
         $this->middleware('permission:tender-create', ['only' => ['create','store']]);
         $this->middleware('permission:tender-edit',   ['only' => ['edit','update']]);
         $this->middleware('permission:tender-delete', ['only' => ['destroy']]);

        $this->tender = new TenderSubmissionService;
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
        return view('tender_submissions.show')->with(compact('tenderSubmission'));
    }


}
