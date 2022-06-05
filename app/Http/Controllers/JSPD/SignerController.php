<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use App\Models\Signer;
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

        $assigned_signers = Signer::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->where('type','signer')->get()->pluck('user_id')->toArray();
        $assigned_admins = Signer::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->where('type','urusetia')->get()->pluck('user_id')->toArray();
        $signers = User::role('JSPD-PENANDA')->get(); // list all users in signers category
        $admins = User::role('JSPD-URUSETIA')->get(); // list all users in signers category
        return view('JSPD.signers.show')->with(compact('tenderSubmission','signers','admins','assigned_signers','assigned_admins'));
    }

    public function search(Request $request){
        $proposals = $this->signer->search($request);
        return view('JSPD.signers.index')->with(compact('proposals'));
    }

    /// scoring-create
    public function create(){}

    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){

        $this->signer->store($request->input('signers'),'signer',  $tenderSubmission);
        $this->signer->store($request->input('admins'),'urusetia', $tenderSubmission);

        return redirect('signers')->with('success','Proposal '. $tenderSubmission->id .' successfully updated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
