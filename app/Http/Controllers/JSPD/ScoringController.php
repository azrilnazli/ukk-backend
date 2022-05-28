<?php
namespace App\Http\Controllers\JSPD;

use App\Http\Controllers\Controller;
use App\Models\TenderSubmissions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScoringController extends Controller
{
    function __construct()
    {
        $this->middleware( 'permission:scoring-list',     ['only' => ['dashboard','index','show','search']] );
        $this->middleware( 'permission:scoring-create',   ['only' => ['create','store']] );
        $this->middleware( 'permission:scoring-edit',     ['only' => ['edit','update']] );
        $this->middleware( 'permission:scoring-delete',   ['only' => ['delete']] );
    }

    // scoring-list
    public function dashboard(){}
    public function index(){}
    public function show(){}
    public function search(){}

    // scoring-create
    public function create(){}
    public function store(){}

    // scoring-edit
    public function edit(){}
    public function update(){}

    // scoring-delete
    public function delete(){}


}
