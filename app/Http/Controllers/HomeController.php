<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Storage;
use Hash;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::user()->hasRole('subscriber'))
        {
            // do something
            Auth::logout();
            Session::flush();
            return redirect()->to('https://ukk.rtm.gov.my');
        }
        
       
        $users = null;

        $users = User::query()
        ->orderBy('id','desc')
        ->limit(5)
        ->get();

        $requested = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->limit(5)
        ->get();

        $rejected = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', false)
        ->where('is_rejected', true)
        ->limit(5)
        ->get();

        $approved = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_approved', true)
        ->limit(5)
        ->get();

        $resubmit = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_rejected', true)
        ->limit(5)
        ->get();

        $total['registered'] = Company::query()->count();

        $total['pending'] = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_rejected', false)
        ->where('is_approved', false)
        ->count();

        $total['rejected'] = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', false)
        ->where('is_rejected', true)
        ->count();

        $total['approved'] = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_approved', true)
        ->count();

        $total['resubmit'] = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_rejected', true)
        ->count();

        //dd($total);

        return view('home')->with(compact('users','requested','rejected','approved','resubmit','total'));
    }
}
