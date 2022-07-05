<?php
namespace App\Http\Controllers\Pitching;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use App\Models\PitchingSigner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Scoring;
use App\Models\User;
use App\Services\Pitching\SignerService;
use App\Http\Requests\PitchingSigner\StoreRequest;
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

        $assigned_signers = PitchingSigner::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->where('type','signer')->get()->pluck('user_id')->toArray();
        $assigned_admins = PitchingSigner::query()->select('user_id')->where('tender_submission_id', $tenderSubmission->id)->where('type','urusetia')->get()->pluck('user_id')->toArray();
        $signers = User::role('jspd-penanda')->get(); // list all users in signers category
        $admins = User::role('jspd-urusetia')->get(); // list all users in signers category
        $fields = \App\Services\TenderSubmissionService::fields($tenderSubmission);

        if($tenderSubmission->added_by == 0){ // 0 means not being assigned yet
            return view('pitching.signers.show')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
        } else {
            // only owner of the signers can edit
            if($tenderSubmission->added_by == auth()->user()->id ){
                return view('pitching.signers.show')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
            } else {
                return view('pitching.signers.disabled')->with(compact('tenderSubmission','fields','signers','admins','assigned_signers','assigned_admins'));
            }
        }
    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('pitching.signers.index')->with(compact('proposals'));
    }

    /// scoring-create
    public function create(){}

    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){

        // update added_by in TenderSubmission table
        $tenderSubmission->added_by = auth()->user()->id;
        $tenderSubmission->save();

        // store in signers table
        $this->service->store($request->input('signers'),'signer',  $tenderSubmission);
        $this->service->store($request->input('admins'),'urusetia', $tenderSubmission);

        return redirect('signers')->with('success','Proposal '. $tenderSubmission->id .' successfully updated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
