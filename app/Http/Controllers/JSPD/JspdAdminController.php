<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Scoring;
use Auth;
use App\Services\JspdAdminService;
use App\Http\Requests\JspdAdmin\StoreApprovalRequest;

class JspdAdminController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:jspd-admin-list',     ['only' => ['dashboard','index','show','search']] );
        $this->middleware( 'permission:jspd-admin-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:jspd-admin-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:jspd-admin-delete',   ['only' => ['delete']] );

        $this->service = new JspdAdminService;
    }

    public function dashboard(){}
    public function index(){
        // list all tender_submissions
        // count assigned signers
        // count assigned urusetias
        // searchable by company name & id
        $proposals = $this->service->paginate(50);
        return view('JSPD.admins.index', compact('proposals'));
    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('JSPD.admins.index', compact('proposals'));
    }

    public function show(TenderSubmission $tenderSubmission)
    {

        $scorings = Scoring::query()
                        ->with('user')
                        ->where('tender_submission_id', $tenderSubmission->id )
                        ->get();
        return view('JSPD.admins.show')->with(compact('tenderSubmission','scorings'));
    }


    public function create(){}

    public function store(StoreApprovalRequest $request,TenderSubmission $tenderSubmission){


        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;

        $verification = $this->scoring->store_verification($request);
        return redirect(route('scorings.tasks'))->with('success','Proposal '. $verification->id .' successfully verified.');
    }
    public function edit(){}
    public function update(){}
    public function delete(){}
}
