<?php
namespace App\Http\Controllers\Pitching;

use App\Http\Controllers\Controller;

use App\Models\TenderSubmission;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\Pitching\VerificationService;
use App\Http\Requests\Pitching\Verification\StoreRequest;
use Route;

class VerificationController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:pitching-verification-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:pitching-verification-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:pitching-verification-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:pitching-verification-delete',   ['only' => ['delete']] );

        $this->service = new VerificationService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/pitching-verifications', [VerificationController::class, 'index'])->name('pitching-verifications.index');
        Route::get('/pitching-verifications/dashboard', [VerificationController::class, 'tasks'])->name('pitching-verifications.dashboard');
        Route::get('/pitching-verifications/tasks', [VerificationController::class, 'tasks'])->name('pitching-verifications.tasks');
        Route::get('/pitching-verifications/pending_tasks', [VerificationController::class, 'pending_tasks'])->name('pitching-verifications.pending_tasks');
        Route::get('/pitching-verifications/finished_tasks', [VerificationController::class, 'finished_tasks'])->name('pitching-verifications.finished_tasks');
        Route::get('/pitching-verifications/search', [VerificationController::class, 'search'])->name('pitching-verifications.search');
        Route::get('/pitching-verifications/dashboard', [VerificationController::class, 'dashboard'])->name('pitching-verifications.dashboard');
        Route::get('/pitching-verifications/create', [VerificationController::class,'create'])->name('pitching-verifications.create');
        Route::get('/pitching-verifications/{role}/edit', [VerificationController::class,'edit'])->name('pitching-verifications.edit');
        Route::put('/pitching-verifications/{role}/edit', [VerificationController::class,'update'])->name('pitching-verifications.update');
        Route::delete('/pitching-verifications/{role}', [VerificationController::class, 'delete'])->name('pitching-verifications.destroy');
        Route::get('/pitching-verifications/{tenderSubmission}', [VerificationController::class, 'show'])->name('pitching-verifications.show');
        Route::post('/pitching-verifications/{tenderSubmission}', [VerificationController::class,'store'])->name('pitching-verifications.store');
    }

    // signer-list
    public function dashboard(){
        return view('pitching.verifications.dashboard');
    }


    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('pitching.verifications.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function pending_tasks()
    {
        $proposals = $this->service->pending_tasks();
        return view('pitching.verifications.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function finished_tasks()
    {
        $proposals = $this->service->finished_tasks();
        return view('pitching.verifications.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
        // show TenderSubmission data
        // with form
        //dd($tenderSubmission->pitching_verification);
        return view('pitching.verifications.show')->with(compact('tenderSubmission'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('pitching.verifications.index')->with(compact('proposals'));
    }

    // verification form
    public function create(){

    }


    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){
        $result = $this->service->store($request, $tenderSubmission);
        // redirect
        return redirect(route('pitching-verifications.finished_tasks'))->with('success','Proposal '. $tenderSubmission->id .' successfully scored.');
    }

    // verification-edit
    public function edit(){}
    public function update(){}

    // verification-delete
    public function delete(){}
}
