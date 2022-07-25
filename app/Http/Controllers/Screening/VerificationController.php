<?php
namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;

use App\Models\TenderSubmission;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\Screening\VerificationService;
use App\Http\Requests\Screening\Verification\StoreRequest;
use Route;

class VerificationController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:screening-verification-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:screening-verification-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:screening-verification-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:screening-verification-delete',   ['only' => ['delete']] );

        $this->service = new VerificationService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/screening-verifications', [VerificationController::class, 'index'])->name('screening-verifications.index');
        Route::get('/screening-verifications/dashboard', [VerificationController::class, 'tasks'])->name('screening-verifications.dashboard');
        Route::get('/screening-verifications/tasks', [VerificationController::class, 'tasks'])->name('screening-verifications.tasks');
        Route::get('/screening-verifications/pending-tasks', [VerificationController::class, 'pendingTasks'])->name('screening-verifications.pending-tasks');
        Route::get('/screening-verifications/finished-tasks', [VerificationController::class, 'finishedTasks'])->name('screening-verifications.finished-tasks');
        Route::get('/screening-verifications/search', [VerificationController::class, 'search'])->name('screening-verifications.search');
        Route::get('/screening-verifications/dashboard', [VerificationController::class, 'dashboard'])->name('screening-verifications.dashboard');
        Route::get('/screening-verifications/create', [VerificationController::class,'create'])->name('screening-verifications.create');
        Route::get('/screening-verifications/{role}/edit', [VerificationController::class,'edit'])->name('screening-verifications.edit');
        Route::put('/screening-verifications/{role}/edit', [VerificationController::class,'update'])->name('screening-verifications.update');
        Route::delete('/screening-verifications/{role}', [VerificationController::class, 'delete'])->name('screening-verifications.destroy');
        Route::get('/screening-verifications/{tenderSubmission}', [VerificationController::class, 'show'])->name('screening-verifications.show');
        Route::post('/screening-verifications/{tenderSubmission}', [VerificationController::class,'store'])->name('screening-verifications.store');
    }

    // signer-list
    public function dashboard(){
        return view('screening.verifications.dashboard');
    }


    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('screening.verifications.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function pendingTasks()
    {
        // show owned proposal but not verify yet
        $proposals = $this->service->pendingTasks();
        return view('screening.verifications.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function finishedTasks()
    {
        // show verified proposal
        $proposals = $this->service->finishedTasks();
        return view('screening.verifications.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
        // show TenderSubmission data
        // with form
        //dd($tenderSubmission->screening_scorings);
        return view('screening.verifications.show')->with(compact('tenderSubmission'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('screening.verifications.index')->with(compact('proposals'));
    }

    // verification form
    public function create(){

    }


    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){
        $result = $this->service->store($request, $tenderSubmission);
        // redirect
        return redirect(route('screening-verifications.finished-tasks'))->with('success','Proposal '. $tenderSubmission->id .' successfully scored.');
    }

    // verification-edit
    public function edit(){}
    public function update(){}

    // verification-delete
    public function delete(){}
}
