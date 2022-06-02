<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\ScoringService;
use App\Http\Requests\Scoring\StoreScoringRequest;

class ScoringController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:scoring-list',     ['only' => ['dashboard','index','show','search']] );
        $this->middleware( 'permission:scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:scoring-delete',   ['only' => ['delete']] );

        $this->scoring = new ScoringService;
    }

    // scoring-list
    public function dashboard(){}
    
    public function index()
    {
        $proposals = $this->scoring->paginate();
        return view('JSPD.scorings.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
       return view('JSPD.scorings.show')->with(compact('tenderSubmission'));
    }

    public function search(Request $request){

        $proposals = $this->scoring->search($request);
        return view('JSPD.scorings.index')->with(compact('proposals'));
    }

    // scoring-create
    public function create(){}

    public function store(StoreScoringRequest $request, TenderSubmission $tenderSubmission){
       
        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;
        $request['tender_id'] =  $tenderSubmission->tender_id;
        $request['company_id'] =  $tenderSubmission->user->company->id;
     
        $scoring = $this->scoring->store($request);
        return redirect('scorings')->with('success','Proposal '. $scoring->id .' successfully validated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
