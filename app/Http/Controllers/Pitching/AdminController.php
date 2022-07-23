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

use App\Services\Pitching\AdminService;
use App\Http\Requests\Pitching\Approval\StoreRequest;
use Route;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:pitching-admin-list',     ['only' => ['dashboard','index','show','search','tasks']] );
        $this->middleware( 'permission:pitching-admin-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:pitching-admin-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:pitching-admin-delete',   ['only' => ['delete']] );

        $this->service = new AdminService;
    }

    static function routes()
    {
        // JSPD - signers
        Route::get('/pitching-admins', [AdminController::class, 'index'])->name('pitching-admins.index');
        Route::get('/pitching-admins/dashboard', [AdminController::class, 'dashboard'])->name('pitching-admins.dashboard');
        Route::get('/pitching-admins/pending-tasks', [AdminController::class, 'pendingTasks'])->name('pitching-admins.pending-tasks');
        Route::get('/pitching-admins/finished-tasks', [AdminController::class, 'finishedTasks'])->name('pitching-admins.finished-tasks');
        Route::get('/pitching-admins/search', [AdminController::class, 'search'])->name('pitching-admins.search');

    }

    // signer-list
    public function dashboard(){
        $total['total_proposals'] = $this->service->totalProposals();
        $total['approved_proposals'] = $this->service->approvedProposals();
        return view('pitching.admins.dashboard')->with(compact('total'));
    }

    // list all proposal for urusetia to assign
    public function index()
    {
        $proposals = $this->service->paginate();
        return view('pitching.admins.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function pendingTasks()
    {
        $proposals = $this->service->pendingTasks();
        return view('pitching.admins.index')->with(compact('proposals'));
    }

    // list all proposal for urusetia to assign
    public function finishedTasks()
    {
        $proposals = $this->service->finishedTasks();
        return view('pitching.admins.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
        // show TenderSubmission data
        // with form
        //dd($tenderSubmission->pitching_scoring);
        return view('pitching.admins.show')->with(compact('tenderSubmission'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('pitching.admins.index')->with(compact('proposals'));
    }



    public function store(StoreRequest $request, TenderSubmission $tenderSubmission){
        $result = $this->service->store($request, $tenderSubmission);
        // redirect
        return redirect(route('pitching-admins.finished_tasks'))->with('success','Proposal '. $tenderSubmission->id .' successfully scored.');
    }


}
