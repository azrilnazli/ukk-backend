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
use Route;

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

    static function routes()
    {
        Route::get('/jspd-admins/pending_tasks', [JspdAdminController::class, 'pending_tasks'])->name('jspd-admins.pending_tasks');
        Route::get('/jspd-admins/finished_tasks', [JspdAdminController::class, 'finished_tasks'])->name('jspd-admins.finished_tasks');
        Route::get('/jspd-admins', [JspdAdminController::class, 'index'])->name('jspd-admins.index');
        Route::get('/jspd-admins/approved', [JspdAdminController::class, 'approved'])->name('jspd-admins.approved');
        Route::get('/jspd-admins/failed', [JspdAdminController::class, 'failed'])->name('jspd-admins.failed');
        Route::get('/jspd-admins/awaiting', [JspdAdminController::class, 'awaiting'])->name('jspd-admins.awaiting');
        Route::get('/jspd-admins/search', [JspdAdminController::class, 'search'])->name('jspd-admins.search');
        Route::get('/jspd-admins/dashboard', [JspdAdminController::class, 'dashboard'])->name('jspd-admins.dashboard');
        Route::get('/jspd-admins/create', [JspdAdminController::class,'create'])->name('jspd-admins.create');
        Route::get('/jspd-admins/{role}/edit', [JspdAdminController::class,'edit'])->name('jspd-admins.edit');
        Route::put('/jspd-admins/{role}/edit', [JspdAdminController::class,'update'])->name('jspd-admins.update');
        Route::delete('/jspd-admins/{role}', [JspdAdminController::class, 'delete'])->name('jspd-admins.destroy');
        Route::get('/jspd-admins/{tenderSubmission}', [JspdAdminController::class, 'show'])->name('jspd-admins.show');
        Route::post('/jspd-admins/{tenderSubmission}', [JspdAdminController::class,'store'])->name('jspd-admins.store');
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

    public function pending_tasks(){
        $proposals = $this->service->pending_tasks(50);
        return view('JSPD.admins.index', compact('proposals'));
    }
    public function finished_tasks(){
        $proposals = $this->service->finished_tasks(50);
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

    public function awaiting(){

        $proposals = $this->service->awaiting(50);
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

        if(Auth::user()->hasAnyRole(['jspd-admin','super-admin'])){

            $tenderSubmission = $this->service->destroy($id);

            return redirect(route('jspd-admins.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully removed.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
