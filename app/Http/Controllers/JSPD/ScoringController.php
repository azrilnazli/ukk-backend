<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Scoring;
use App\Models\Signer;
use App\Services\ScoringService;
use App\Http\Requests\Scoring\StoreScoringRequest;
use App\Http\Requests\Scoring\StoreVerificationRequest;
use Auth;
use Route;

class ScoringController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:scoring-list',     ['only' => ['dashboard','index','show','search','tasks','company']] );
        $this->middleware( 'permission:scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:scoring-delete',   ['only' => ['delete']] );

        $this->scoring = new ScoringService;
    }

    static function routes()
    {
        // JSPD - scorings
        Route::get('/scorings', [ScoringController::class, 'index'])->name('scorings.index');
        Route::get('/scorings/tasks', [ScoringController::class, 'tasks'])->name('scorings.tasks');
        Route::get('/scorings/search', [ScoringController::class, 'search'])->name('scorings.search');
        Route::get('/scorings/dashboard', [ScoringController::class, 'dashboard'])->name('scorings.dashboard');
        Route::get('/scorings/create', [ScoringController::class,'create'])->name('scorings.create');
        Route::get('/scorings/{company}/company', [ScoringController::class,'company'])->name('scorings.company');
        Route::get('/scorings/{role}/edit', [ScoringController::class,'edit'])->name('scorings.edit');
        Route::put('/scorings/{role}/edit', [ScoringController::class,'update'])->name('scorings.update');
        Route::delete('/scorings/{role}', [ScoringController::class, 'delete'])->name('scorings.destroy');
        Route::post('/scorings/{tenderSubmission}', [ScoringController::class,'store'])->name('scorings.store');
        Route::post('/scorings/{tenderSubmission}/verification', [ScoringController::class,'store_verification'])->name('scorings.store_verification');
        Route::get('/scorings/{tenderSubmission}', [ScoringController::class, 'show'])->name('scorings.show');
        Route::get('/scorings/{tenderSubmission}/verify', [ScoringController::class, 'show_verify'])->name('scorings.show_verify');
        Route::post('/scorings/{tenderSubmission}/verify', [ScoringController::class,'store_verify'])->name('scorings.store_verify');
    }

    // scoring-list
    public function dashboard(){
        return view('JSPD.scorings.dashboard');
    }

    public function index()
    {
        $proposals = $this->scoring->paginate();
        return view('JSPD.scorings.index')->with(compact('proposals'));
    }

    public function tasks(){
        if(Auth::user()->hasRole('JSPD-PENANDA')){
            // list proposal assigned to JSPD-PENANDA
            $proposals = $this->scoring->tasks('signers', 50); // relation signers()
        }

        if(Auth::user()->hasRole('JSPD-URUSETIA')){
            // list proposal assigned to JSPD-PENANDA
            $proposals = $this->scoring->tasks('urusetias', 50); // relation signers()
        }

        return view('JSPD.scorings.tasks')->with(compact('proposals'));
    }

    // used by JSPD-PENANDA to show their task
    public function show(TenderSubmission $tenderSubmission)
    {
        // check if current user is assigned in signers

        if(
            !$tenderSubmission
            ->allowed_users // relationship
            ->pluck('user_id') // db field array to compare
            ->contains( auth()->user()->id ) // value to compare
        ){
            abort(403);
        }


        // every PENANDA only assigned 1 PROPOSAL
        $data = Scoring::query()
                ->where('tender_submission_id', $tenderSubmission->id ) // proposal id
                ->where('user_id', auth()->user()->id ) // penanda id
                ->first();

        return view('JSPD.scorings.show')->with(compact('tenderSubmission','data'));
    }

    // used by JSPD-URUSETIA to show their task
    public function show_verify(TenderSubmission $tenderSubmission)
    {
        if(
            !$tenderSubmission
            ->allowed_users // relationship
            ->pluck('user_id') // db field array to compare
            ->contains( auth()->user()->id ) // value to compare
        ){
            abort(403);
        }

        $scorings = Scoring::query()
                        ->with('user')
                        ->where('tender_submission_id', $tenderSubmission->id )
                        ->get();
        //dd($data);


        $tenderSubmission->signers
        ->each( function($val, $key) use ($tenderSubmission) {

                //echo $val->user->name;
        });

        // check urusetia 1

        $tenderSubmission->urusetias
        ->each( function($val, $key) use ($tenderSubmission) {

                //echo $val->user->name;
        });

        $tenderSubmission->verifications
        ->each( function($val, $key) use ($tenderSubmission) {

                //echo $val->user->name;
        });

        // check urusetia 2

        return view('JSPD.scorings.show_verify')->with(compact('tenderSubmission','scorings'));
    }

    public function search(Request $request){

        if(Auth::user()->hasRole('JSPD-PENANDA')){
            // list proposal assigned to JSPD-PENANDA
            // echo 'jspd-penanda';
            // dd($request);
            $proposals = $this->scoring->search('signers', $request); // relation signers()
        }

        if(Auth::user()->hasRole('JSPD-URUSETIA')){
            // list proposal assigned to JSPD-PENANDA
            // echo 'jspd-urusetia';
            // dd($request);
            $proposals = $this->scoring->search('urusetias', $request); // relation signers()
        }

        return view('JSPD.scorings.tasks')->with(compact('proposals'));
    }

    // scoring-create
    public function create(){}

    public function store_verification(StoreVerificationRequest $request,TenderSubmission $tenderSubmission){

        if(
            !$tenderSubmission
            ->urusetias // relationship
            ->pluck('user_id') // db field array to compare
            ->contains( auth()->user()->id ) // value to compare
        ){
            abort(403);
        }

        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;

        $verification = $this->scoring->store_verification($request);
        return redirect(route('scorings.tasks'))->with('success','Proposal '. $verification->id .' successfully verified.');
    }

    public function store(StoreScoringRequest $request, TenderSubmission $tenderSubmission){

        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;
        $request['tender_id'] =  $tenderSubmission->tender_id;
        $request['company_id'] =  $tenderSubmission->user->company->id;

        $scoring = $this->scoring->store($request);
        return redirect(route('scorings.tasks'))->with('success','Proposal '. $scoring->id .' successfully validated.');
    }

    public function store_verify(StoreScoringRequest $request, TenderSubmission $tenderSubmission){

        $request['user_id'] =  auth()->user()->id;
        $request['tender_submission_id'] =  $tenderSubmission->id;
        $request['tender_id'] =  $tenderSubmission->tender_id;
        $request['company_id'] =  $tenderSubmission->user->company->id;

        $scoring = $this->scoring->store($request);
        return redirect(route('scorings.tasks'))->with('success','Proposal '. $scoring->id .' successfully validated.');
    }


    public function company(Company $company)
    {

        $documents = [
            'ssm',
            'mof',
            'finas_fp',
            'finas_fd',
            'kkmm_swasta',
            'kkmm_syndicated',
            'bank',
            'audit',
            'credit',
            'bumiputera'

        ];

        return view('JSPD.scorings.company',compact(['company','documents']));
    }


    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
