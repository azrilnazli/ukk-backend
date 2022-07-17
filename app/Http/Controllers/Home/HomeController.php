<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
use App\Models\QueueMonitor;
use App\Models\Statistics;
use App\Models\Company;
use App\Models\Comment;
use App\Models\Tender;
use App\Models\TenderSubmission;
use App\Models\Video;
use Illuminate\Http\Request;
use Storage;
use Hash;
use Auth;
use Session;
use Route;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public $service;

    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new \App\Services\HomeService;
    }

    static function routes()
    {
        // HomeController
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('home.dashboard');
        Route::get('/queue/jobs', [HomeController::class, 'jobs'])->name('videos.jobs');
        Route::prefix('jobs')->group(function () {
            Route::queueMonitor();
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Subscriber shall not access!
        if(Auth::user()->hasRole('pembekal'))
        {
            // do something
            Auth::logout();
            Session::flush();
            return redirect()->to(env('FRONTEND_URL'));
        }

        // JSPD
        if(Auth::user()->hasAnyRole(['jspd-penanda','jspd-urusetia']))
        {
            return redirect()->to(route('scorings.dashboard'));
        }

        // if role pitching-urusetia
        if(Auth::user()->hasAnyRole(['pitching-urusetia']))
        {
            return redirect()->to(route('pitching-signers.dashboard'));
        }

        // if role pitching-penanda
        if(Auth::user()->hasAnyRole(['pitching-penanda']))
        {
            return redirect()->to(route('pitching-scorings.dashboard'));
        }



        return redirect()->to(route('home.dashboard'));


    }

    function dashboard(){


        $company['total'] = Company::query()->count();

        // comment related
        $comment['total'] = Comment::query()->count();

        // approval related
        $approval['total'] = \App\Models\CompanyApproval::query()->count();

        // tender related
        $tenderDetails = \App\Models\TenderDetail::all();

        // state related
        // $states = Company::distinct()
        //             ->get(['states'])
        //             ->map( function($val, $key)  {
        //                 $val['count'] = Company::query()
        //                 ->where('states', 'LIKE', '%'.$val->states.'%')
        //                 ->count();
        //                 return $val;
        //             });

        $video = $this->service->video();
        $proposal = $this->service->proposal();

        $roles = \Spatie\Permission\Models\Role::query()
                ->withCount('users')
                ->whereNotIn('name', ['user'])
                ->get();


        return view('home')->with(compact(

            'company',
            'approval',
            'tenderDetails',
            'comment',
            'proposal',
            'video',
            //'states',
            'roles',

        ));
    }

    function jobs(){
        return view('home.jobs');
    }
}
