<?php
namespace App\Http\Controllers\Pitching;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Scoring;
use Auth;
use App\Services\PitchingAdminService;
use App\Http\Requests\PitchingAdmin\StoreApprovalRequest;
use Route;

class PitchingAdminController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:pitching-admin-list',     ['only' => ['dashboard','index','show','search','approved','failed','pending']] );
        $this->middleware( 'permission:pitching-admin-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:pitching-admin-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:pitching-admin-delete',   ['only' => ['delete']] );
        $this->service = new PitchingAdminService;
    }

    static function routes()
    {
        Route::get('/pitching-admins', [PitchingAdminController::class, 'index'])->name('pitching-admins.index');
        Route::get('/pitching-admins/approved', [PitchingAdminController::class, 'approved'])->name('pitching-admins.approved');
        Route::get('/pitching-admins/failed', [PitchingAdminController::class, 'failed'])->name('pitching-admins.failed');
        Route::get('/pitching-admins/pending', [PitchingAdminController::class, 'pending'])->name('pitching-admins.pending');
        Route::get('/pitching-admins/search', [PitchingAdminController::class, 'search'])->name('pitching-admins.search');
        Route::get('/pitching-admins/dashboard', [PitchingAdminController::class, 'dashboard'])->name('pitching-admins.dashboard');
        Route::get('/pitching-admins/create', [PitchingAdminController::class,'create'])->name('pitching-admins.create');
        Route::get('/pitching-admins/{role}/edit', [PitchingAdminController::class,'edit'])->name('pitching-admins.edit');
        Route::put('/pitching-admins/{role}/edit', [PitchingAdminController::class,'update'])->name('pitching-admins.update');
        Route::delete('/pitching-admins/{role}', [PitchingAdminController::class, 'delete'])->name('pitching-admins.destroy');
        Route::get('/pitching-admins/{tenderSubmission}', [PitchingAdminController::class, 'show'])->name('pitching-admins.show');
        Route::post('/pitching-admins/{tenderSubmission}', [PitchingAdminController::class,'store'])->name('pitching-admins.store');
    }

    public function dashboard(){}
    public function index(){
        // list all tender_submissions
        // count assigned signers
        // count assigned urusetias
        // searchable by company name & id
        $proposals = $this->service->paginate(50);
        return view('pitchings.admins.index', compact('proposals'));
    }

    public function approved(){

        $proposals = $this->service->approved(50);
        return view('pitchings.admins.index', compact('proposals'));

    }

    public function failed(){

        $proposals = $this->service->failed(50);
        return view('pitchings.admins.index', compact('proposals'));

    }

    public function pending(){

        $proposals = $this->service->pending(50);
        return view('pitchings.admins.index', compact('proposals'));

    }

    public function search(Request $request){
        $proposals = $this->service->search($request);
        return view('pitchings.admins.index', compact('proposals'));
    }

    public function show(TenderSubmission $tenderSubmission)
    {

        $scorings = Scoring::query()
                        ->with('user')
                        ->where('tender_submission_id', $tenderSubmission->id )
                        ->get();
        return view('pitchings.admins.show')->with(compact('tenderSubmission','scorings'));
    }


    public function create(){}

    public function store(StoreApprovalRequest $request,TenderSubmission $tenderSubmission){

        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;

        $approval = $this->service->store($request);
        return redirect(route('pitching-admins.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully approved.');
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

        if(Auth::user()->hasAnyRole(['pitching-admin','super-admin'])){

            $tenderSubmission = $this->service->destroy($id);

            return redirect(route('pitching-admins.index'))->with('success','Proposal '. $tenderSubmission->id .' successfully removed.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
