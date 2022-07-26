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

use App\Services\Screening\AdminService;
use App\Http\Requests\Screening\Approval\StoreRequest;
use Route;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:screening-admin-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:screening-admin-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:screening-admin-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:screening-admin-delete',   ['only' => ['delete']] );

        $this->service = new AdminService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/screening-admins', [AdminController::class, 'index'])->name('screening-admins.index');
        Route::get('/screening-admins/dashboard', [AdminController::class, 'dashboard'])->name('screening-admins.dashboard');
        Route::get('/screening-admins/pending-tasks', [AdminController::class, 'pendingTasks'])->name('screening-admins.pending-tasks');
        Route::get('/screening-admins/finished-tasks', [AdminController::class, 'finishedTasks'])->name('screening-admins.finished-tasks');
        Route::get('/screening-admins/search', [AdminController::class, 'search'])->name('screening-admins.search');

    }

    // signer-list
    public function dashboard(){

        $proposals = $this->service->paginate();
        $scores = $this->service->scores();

        //dd($scores);
        $total['total_proposals'] = $this->service->totalProposals();
        $total['approved_proposals'] = $this->service->approvedProposals();
        return view('screening.admins.dashboard')->with(compact('total','proposals','scores'));
    }

    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('screening.admins.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function pendingTasks()
    {

        $proposals = $this->service->pendingTasks();
        return view('screening.admins.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function finishedTasks()
    {
        $proposals = $this->service->finishedTasks();
        return view('screening.admins.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
        // show TenderSubmission data
        // with form
        //dd($tenderSubmission->screening_scoring);
        return view('screening.admins.show')->with(compact('tenderSubmission'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('screening.admins.index')->with(compact('proposals'));
    }



    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){
        $result = $this->service->store($request, $tenderSubmission);
        // redirect
        return redirect(route('screening-admins.finished_tasks'))->with('success','Proposal '. $tenderSubmission->id .' successfully scored.');
    }


}
