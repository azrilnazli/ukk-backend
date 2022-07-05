<?php
namespace App\Http\Controllers\Pitching;

use App\Http\Controllers\Controller;

use App\Models\TenderSubmission;
use App\Models\PitchingSigner;
use App\Models\PitchingUrusetia;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\Pitching\SignerService;
use App\Http\Requests\Pitching\Signer\StoreRequest;
use Route;

class SignerController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:pitching-signer-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:pitching-signer-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:pitching-signer-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:pitching-signer-delete',   ['only' => ['delete']] );

        $this->service = new SignerService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/pitching-signers', [SignerController::class, 'index'])->name('pitching-signers.index');
        Route::get('/pitching-signers/dashboard', [SignerController::class, 'tasks'])->name('pitching-signers.dashboard');
        Route::get('/pitching-signers/tasks', [SignerController::class, 'tasks'])->name('pitching-signers.tasks');
        Route::get('/pitching-signers/pending_tasks', [SignerController::class, 'pending_tasks'])->name('pitching-signers.pending_tasks');
        Route::get('/pitching-signers/finished_tasks', [SignerController::class, 'finished_tasks'])->name('pitching-signers.finished_tasks');
        Route::get('/pitching-signers/search', [SignerController::class, 'search'])->name('pitching-signers.search');
        Route::get('/pitching-signers/dashboard', [SignerController::class, 'dashboard'])->name('pitching-signers.dashboard');
        Route::get('/pitching-signers/create', [SignerController::class,'create'])->name('pitching-signers.create');
        Route::get('/pitching-signers/{role}/edit', [SignerController::class,'edit'])->name('pitching-signers.edit');
        Route::put('/pitching-signers/{role}/edit', [SignerController::class,'update'])->name('pitching-signers.update');
        Route::delete('/pitching-signers/{role}', [SignerController::class, 'delete'])->name('pitching-signers.destroy');
        Route::get('/pitching-signers/{tenderSubmission}', [SignerController::class, 'show'])->name('pitching-signers.show');
        Route::post('/pitching-signers/{tenderSubmission}', [SignerController::class,'store'])->name('pitching-signers.store');
    }

    // signer-list
    public function dashboard(){
        return view('pitching.signers.dashboard');
    }


    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('pitching.signers.index')->with(compact('proposals'));
    }

    // tasks assigned to user()->id
    public function tasks()
    {
        $proposals = $this->service->tasks();

        //dd($proposals);

        return view('pitching.signers.tasks')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {

        $assigned_signers = PitchingSigner::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->get()->pluck('user_id')->toArray();
        $assigned_admins = PitchingUrusetia::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->get()->pluck('user_id')->toArray();
        $signers = User::role('pitching-penanda')->get(); // list all users in signers category
        $admins = User::role('pitching-urusetia')->get(); // list all users in urusetias category
        $fields = \App\Services\TenderSubmissionService::fields($tenderSubmission);

        //dd($signers);
        // to check TenderSubmission ownership
        if($tenderSubmission->pitching_owner){
            // assigned , now check is logged user own the TenderSubmission
            if($tenderSubmission->pitching_owner->user_id == auth()->user()->id){
                return view('pitching.signers.show')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
            } else {
                // show disabled view
                return view('pitching.signers.disabled')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
            }
        } else {
            // not assigned yet
            return view('pitching.signers.show')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
        }

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('pitching.signers.index')->with(compact('proposals'));
    }

    // scoring-create
    public function create(){}


    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){

        // create ownership
        $this->service->storeOwner($tenderSubmission);
        // store in PitchingSigner
        $this->service->storeSigner($request->input('signers'),  $tenderSubmission);
        // store in PitchingUrusetia
        $this->service->storeUrusetia($request->input('admins'), $tenderSubmission);
        // redirect
        return redirect(route('pitching-signers.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully updated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
