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
        //  $this->middleware('permission:Tender-list|Tender-create|Tender-edit|Tender-delete', ['only' => ['index','show']]);
        //  $this->middleware('permission:Tender-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:Tender-edit',   ['only' => ['edit','update']]);
        //  $this->middleware('permission:Tender-delete', ['only' => ['destroy']]);

        $this->tender = new TenderSubmissionService;
    }

    public function index()
    {
        $proposals = $this->tender->paginate();
        return view('tender_submissions.index')->with(compact('proposals'));
    }

    public function search(Request $request){


        $proposals = TenderSubmission::query()

                        ->orWhereHas('user.company', fn($query) =>
                            $query->where('name', 'LIKE', '%' . $q . '%')
                            ->orWhere('email', 'LIKE', '%' . $q . '%')
                            ->orWhere('id', 'LIKE', '%' . $q . '%')
                            ->orWhere('phone', 'LIKE', '%' . $q . '%')

                        )
                        ->orWhereHas('tender', fn($query) =>
                            $query->where('tender_category', 'LIKE', '%' . $q . '%')
                            ->orWhere('type', 'LIKE', '%' . $q . '%')
                            ->orWhere('duration', 'LIKE', '%' . $q . '%')
                            ->orWhere('channel', 'LIKE', '%' . $q . '%')
                            ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                        )

                        ->paginate(50)
                        ->setPath(route('tender_submissions.index'));

                        $tenders->appends([
                            '_token' => $t,
                            'query' => $q
                            ]
                        );
        return view('tender_submissions.index')->with(compact('proposals'));
    }

    // TenderProgrammeCode $tenderProgrammeCode
    public function show(TenderSubmission $tenderSubmission)
    {
        return view('tender_submissions.show')->with(compact('tenderSubmission'));
    }


}
