<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Scoring;
use App\Models\User;
use App\Services\SignerService;
use App\Http\Requests\Signer\StoreRequest;

class SignerController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:signer-list',     ['only' => ['dashboard','index','show','search']] );
        $this->middleware( 'permission:signer-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:signer-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:signer-delete',   ['only' => ['delete']] );

        $this->signer = new SignerService;
    }

    // signer-list
    public function dashboard(){}
    
    public function index()
    {
        $proposals = $this->signer->paginate();
        return view('JSPD.signers.index')->with(compact('proposals'));
    }

    public function show(TenderSubmission $tenderSubmission)
    {
        $signers = User::role('JSPD-PENANDA')->get(); // list all users in signers category
        $admins = User::role('JSPD-URUSETIA')->get(); // list all users in signers category
        return view('JSPD.signers.show')->with(compact('tenderSubmission','signers','admins'));
    }

    public function search(Request $request){
        $proposals = $this->signer->search($request);
        return view('JSPD.signers.index')->with(compact('proposals'));
    }

    // scoring-create
    public function create(){}

    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){

        //dd($tenderSubmission->id);
        dd($request->input());
        $signers = $request->input('signers'); 
        $admins = $request->input('admins');

        // $request['user_id'] =  auth()->user()->id;
        // $request['tender_submission_id'] =  $tenderSubmission->id;
        // $request['tender_id'] =  $tenderSubmission->tender_id;
        // $request['company_id'] =  $tenderSubmission->user->company->id;
     
        // $scoring = $this->signer->store($request);
        // return redirect('signers')->with('success','Proposal '. $scoring->id .' successfully validated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
