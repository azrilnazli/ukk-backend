<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Scoring;
use App\Services\ScoringService;
use App\Http\Requests\Scoring\StoreScoringRequest;
use Auth;

class ScoringController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:scoring-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:scoring-delete',   ['only' => ['delete']] );

        $this->scoring = new ScoringService;
    }

    // scoring-list
    public function dashboard(){
        return view('JSPD.scorings.dashboard');
    }
    
    public function index()
    {
        $proposals = $this->scoring->paginate();
        return view('JSPD.scorings.index')->with(compact('proposals'));
    }

    public function tasks(){
        if(Auth::user()->hasRole('JSPD-PENANDA')){
            // list proposal assigned to JSPD-PENANDA
            $proposals = $this->scoring->tasks('signers', 50); // relation signers()
        }
        if(Auth::user()->hasRole('JSPD-URUSETIA')){
            // list proposal assigned to JSPD-PENANDA
            $proposals = $this->scoring->tasks('urusetia', 50); // relation signers()
        }

        return view('JSPD.scorings.tasks')->with(compact('proposals'));
    }

    // used by JSPD-PENANDA to show their task
    public function show(TenderSubmission $tenderSubmission)
    {
        $data = Scoring::query()
                ->where('tender_submission_id', $tenderSubmission->id ) // proposal id
                ->where('user_id', auth()->user()->id ) // penanda id
                ->first();
        return view('JSPD.scorings.show')->with(compact('tenderSubmission','data'));
    }

    // used by JSPD-URUSETIA to show their task
    public function show_verify(TenderSubmission $tenderSubmission)
    {
        $data = Scoring::query()
                        ->with('user')
                        ->where('tender_submission_id', $tenderSubmission->id )
                        ->first();
        //dd($data);
        return view('JSPD.scorings.show_verify')->with(compact('tenderSubmission','data'));
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
        return redirect(route('scorings.tasks'))->with('success','Proposal '. $scoring->id .' successfully validated.');
    }

    public function store_verify(StoreScoringRequest $request, TenderSubmission $tenderSubmission){
       
        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;
        $request['tender_id'] =  $tenderSubmission->tender_id;
        $request['company_id'] =  $tenderSubmission->user->company->id;
     
        $scoring = $this->scoring->store($request);
        return redirect(route('scorings.tasks'))->with('success','Proposal '. $scoring->id .' successfully validated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
