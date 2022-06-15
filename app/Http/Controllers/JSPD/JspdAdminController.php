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
use Storage;

class JspdAdminController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:jspd-admin-list',     ['only' => ['dashboard','index','show','search','approved','failed','pending']] );
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

    public function approved(){

        $proposals = $this->service->approved(50);
        return view('JSPD.admins.index', compact('proposals'));

    }

    public function failed(){

        $proposals = $this->service->failed(50);
        return view('JSPD.admins.index', compact('proposals'));

    }

    public function pending(){

        $proposals = $this->service->pending(50);
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

        $approval = $this->service->store($request);
        return redirect(route('jspd-admins.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully approved.');
    }
    public function edit(){}
    public function update(){}

    // delete proposal
    // delete scorings
    // delete verifications
    // delete signers
    // delete approval
    // delete videos
    public function delete($id){

        if(Auth::user()->hasAnyRole(['JSPD-ADMIN','super-admin'])){

            $tenderSubmission = TenderSubmission::findOrFail($id);
            $tenderSubmission->scorings()->delete();
            $tenderSubmission->verifications()->delete();
            $tenderSubmission->signers()->delete();
            $tenderSubmission->scorings()->delete();
            $tenderSubmission->approval()->delete();

            if($tenderSubmission->has('video')){
                $this->video = new \App\Services\VideoService;
                if( Storage::disk('assets')->exists($tenderSubmission->id) &&  Storage::disk('streaming')->exists($tenderSubmission->id)  ){
                    //dd($tenderSubmission->id);
                    $this->video->delete($tenderSubmission->video->id);
                }
                $tenderSubmission->video()->delete();
            }

            if(Storage::disk('proposals')->exists($tenderSubmission->id)){
                Storage::disk('proposals')->deleteDirectory( $tenderSubmission->id ); // private dir
            }

            $tenderSubmission->delete();

            return redirect(route('jspd-admins.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully removed.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
