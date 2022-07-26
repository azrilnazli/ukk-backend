<?php
namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;

use App\Models\TenderSubmission;
use App\Models\ScreeningSigner;
use App\Models\ScreeningUrusetia;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\Screening\SignerService;
use App\Http\Requests\Screening\Signer\StoreRequest;
use Route;

class SignerController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:screening-signer-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:screening-signer-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:screening-signer-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:screening-signer-delete',   ['only' => ['delete']] );

        $this->service = new SignerService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/screening-signers', [SignerController::class, 'index'])->name('screening-signers.index');
        Route::get('/screening-signers/dashboard', [SignerController::class, 'tasks'])->name('screening-signers.dashboard');
        Route::get('/screening-signers/tasks', [SignerController::class, 'tasks'])->name('screening-signers.tasks');
        Route::get('/screening-signers/pending-tasks', [SignerController::class, 'pendingTasks'])->name('screening-signers.pending-tasks');
        Route::get('/screening-signers/finished-tasks', [SignerController::class, 'finishedTasks'])->name('screening-signers.finished-tasks');
        Route::get('/screening-signers/search', [SignerController::class, 'search'])->name('screening-signers.search');
        Route::get('/screening-signers/dashboard', [SignerController::class, 'dashboard'])->name('screening-signers.dashboard');
        Route::get('/screening-signers/create', [SignerController::class,'create'])->name('screening-signers.create');
        Route::get('/screening-signers/{role}/edit', [SignerController::class,'edit'])->name('screening-signers.edit');
        Route::put('/screening-signers/{role}/edit', [SignerController::class,'update'])->name('screening-signers.update');
        Route::delete('/screening-signers/{role}', [SignerController::class, 'delete'])->name('screening-signers.destroy');
        Route::get('/screening-signers/{tenderSubmission}', [SignerController::class, 'show'])->name('screening-signers.show');
        Route::post('/screening-signers/{tenderSubmission}', [SignerController::class,'store'])->name('screening-signers.store');
    }

    // signer-list
    public function dashboard(){
        return view('screening.signers.dashboard');
    }


    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('screening.signers.index')->with(compact('proposals'));
    }

    // tasks assigned to user()->id
    public function pendingTasks()
    {
        //dd('test');
        $proposals = $this->service->pendingTasks();
        return view('screening.signers.index')->with(compact('proposals'));
    }

        // tasks assigned to user()->id
    public function finishedTasks()
    {
        $proposals = $this->service->finishedTasks();
        return view('screening.signers.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {

        $assigned_signers = ScreeningSigner::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->get()->pluck('user_id')->toArray();
        $assigned_admins = ScreeningUrusetia::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->get()->pluck('user_id')->toArray();
        $signers = User::role('screening-penanda')->orderBy('name','ASC')->get(); // list all users in signers category
        $admins = User::role('screening-urusetia')->orderBy('name','ASC')->get(); // list all users in urusetias category
        $fields = \App\Services\TenderSubmissionService::fields($tenderSubmission);

        //dd($signers);
        // to check TenderSubmission ownership
        if($tenderSubmission->screening_owner){
            // assigned , now check is logged user own the TenderSubmission
            if($tenderSubmission->screening_owner->user_id == auth()->user()->id){
                return view('screening.signers.show')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
            } else {
                // show disabled view
                return view('screening.signers.disabled')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
            }
        } else {
            // not assigned yet
            return view('screening.signers.show')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
        }

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('screening.signers.index')->with(compact('proposals'));
    }

    // scoring-create
    public function create(){}


    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){

        // create ownership
        $this->service->storeOwner($tenderSubmission);
        // store in ScreeningSigner
        $this->service->storeSigner($request->input('signers'),  $tenderSubmission);
        // store in ScreeningUrusetia
        $this->service->storeUrusetia($request->input('admins'), $tenderSubmission);
        // redirect
        return redirect(route('screening-signers.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully updated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
