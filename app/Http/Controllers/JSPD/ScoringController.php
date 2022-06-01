<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TenderSubmissionService;

class ScoringController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:scoring-list',     ['only' => ['dashboard','index','show','search']] );
        $this->middleware( 'permission:scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:scoring-delete',   ['only' => ['delete']] );

        $this->tender = new TenderSubmissionService;
    }

    // scoring-list
    public function dashboard(){}
    
    public function index()
    {
        $proposals = $this->tender->paginate();
        return view('JSPD.scorings.index')->with(compact('proposals'));
    }


    public function show(TenderSubmission $tenderSubmission)
    {
       return view('JSPD.scorings.show')->with(compact('tenderSubmission'));
    }

    public function search(Request $request){

        $proposals = $this->tender->search($request);
        return view('JSPD.scorings.index')->with(compact('proposals'));
    }

    // scoring-create
    public function create(){}
    
    public function store(Request $request){
        dd($request->input());
    }

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}
}
