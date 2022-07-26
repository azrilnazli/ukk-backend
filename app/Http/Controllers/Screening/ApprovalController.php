<?php
namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;

use App\Models\TenderSubmission;
// use App\Models\ScreeningSigner;
// use App\Models\ScreeningUrusetia;
// use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\Screening\ScoringService;
use App\Http\Requests\Screening\Scoring\StoreRequest;
use Route;

class ApprovalController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:screening-scoring-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:screening-scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:screening-scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:screening-scoring-delete',   ['only' => ['delete']] );

        $this->service = new ScoringService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/screening-scorings', [ScoringController::class, 'index'])->name('screening-scorings.index');
        Route::get('/screening-scorings/dashboard', [ScoringController::class, 'tasks'])->name('screening-scorings.dashboard');
        Route::get('/screening-scorings/tasks', [ScoringController::class, 'tasks'])->name('screening-scorings.tasks');
        Route::get('/screening-scorings/pending_tasks', [ScoringController::class, 'pending_tasks'])->name('screening-scorings.pending_tasks');
        Route::get('/screening-scorings/finished_tasks', [ScoringController::class, 'finished_tasks'])->name('screening-scorings.finished_tasks');
        Route::get('/screening-scorings/search', [ScoringController::class, 'search'])->name('screening-scorings.search');
        Route::get('/screening-scorings/dashboard', [ScoringController::class, 'dashboard'])->name('screening-scorings.dashboard');
        Route::get('/screening-scorings/create', [ScoringController::class,'create'])->name('screening-scorings.create');
        Route::get('/screening-scorings/{role}/edit', [ScoringController::class,'edit'])->name('screening-scorings.edit');
        Route::put('/screening-scorings/{role}/edit', [ScoringController::class,'update'])->name('screening-scorings.update');
        Route::delete('/screening-scorings/{role}', [ScoringController::class, 'delete'])->name('screening-scorings.destroy');
        Route::get('/screening-scorings/{tenderSubmission}', [ScoringController::class, 'show'])->name('screening-scorings.show');
        Route::post('/screening-scorings/{tenderSubmission}', [ScoringController::class,'store'])->name('screening-scorings.store');
    }

    // signer-list
    public function dashboard(){
        return view('screening.scorings.dashboard');
    }


    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('screening.scorings.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function pending_tasks()
    {
        $proposals = $this->service->pending_tasks();
        return view('screening.scorings.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function finished_tasks()
    {
        $proposals = $this->service->finished_tasks();
        return view('screening.scorings.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
        // show TenderSubmission data
        // with form
        //dd($tenderSubmission->screening_scoring);
        return view('screening.scorings.show')->with(compact('tenderSubmission'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('screening.scorings.index')->with(compact('proposals'));
    }

    // scoring form
    public function create(){

    }


    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){
        $result = $this->service->store($request, $tenderSubmission);
        // redirect
        return redirect(route('screening-scorings.finished_tasks'))->with('success','Proposal '. $tenderSubmission->id .' successfully scored.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
