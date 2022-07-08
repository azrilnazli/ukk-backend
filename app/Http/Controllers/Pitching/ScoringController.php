<?php
namespace App\Http\Controllers\Pitching;

use App\Http\Controllers\Controller;

use App\Models\TenderSubmission;
// use App\Models\PitchingSigner;
// use App\Models\PitchingUrusetia;
// use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\Pitching\ScoringService;
use App\Http\Requests\Pitching\Scoring\StoreRequest;
use Route;

class ScoringController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:pitching-scoring-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:pitching-scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:pitching-scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:pitching-scoring-delete',   ['only' => ['delete']] );

        $this->service = new ScoringService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/pitching-scorings', [ScoringController::class, 'index'])->name('pitching-scorings.index');
        Route::get('/pitching-scorings/dashboard', [ScoringController::class, 'tasks'])->name('pitching-scorings.dashboard');
        Route::get('/pitching-scorings/tasks', [ScoringController::class, 'tasks'])->name('pitching-scorings.tasks');
        Route::get('/pitching-scorings/pending_tasks', [ScoringController::class, 'pending_tasks'])->name('pitching-scorings.pending_tasks');
        Route::get('/pitching-scorings/finished_tasks', [ScoringController::class, 'finished_tasks'])->name('pitching-scorings.finished_tasks');
        Route::get('/pitching-scorings/search', [ScoringController::class, 'search'])->name('pitching-scorings.search');
        Route::get('/pitching-scorings/dashboard', [ScoringController::class, 'dashboard'])->name('pitching-scorings.dashboard');
        Route::get('/pitching-scorings/create', [ScoringController::class,'create'])->name('pitching-scorings.create');
        Route::get('/pitching-scorings/{role}/edit', [ScoringController::class,'edit'])->name('pitching-scorings.edit');
        Route::put('/pitching-scorings/{role}/edit', [ScoringController::class,'update'])->name('pitching-scorings.update');
        Route::delete('/pitching-scorings/{role}', [ScoringController::class, 'delete'])->name('pitching-scorings.destroy');
        Route::get('/pitching-scorings/{tenderSubmission}', [ScoringController::class, 'show'])->name('pitching-scorings.show');
        Route::post('/pitching-scorings/{tenderSubmission}', [ScoringController::class,'store'])->name('pitching-scorings.store');
    }

    // signer-list
    public function dashboard(){
        return view('pitching.scorings.dashboard');
    }


    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        //dd($proposals);
        return view('pitching.scorings.index')->with(compact('proposals'));
    }

    // tasks assigned to user()->id
    public function tasks()
    {
        $proposals = $this->service->tasks();

        //dd($proposals);

        return view('pitching.scorings.tasks')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
        // show TenderSubmission data
        // with form
        return view('pitching.scorings.show')->with(compact('tenderSubmission'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('pitching.scorings.index')->with(compact('proposals'));
    }

    // scoring form
    public function create(){

    }


    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){


        // redirect
        return redirect(route('pitching-scorings.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully updated.');
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
