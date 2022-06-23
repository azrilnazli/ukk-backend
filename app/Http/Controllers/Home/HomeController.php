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

    static function routes()
    {
        // HomeController
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('/home', [HomeController::class, 'index'])->name('home');
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
        if(Auth::user()->hasRole('subscriber'))
        {
            // do something
            Auth::logout();
            Session::flush();
            return redirect()->to('https://ukk.rtm.gov.my');
        }

        // Subscriber shall not access!
        if(Auth::user()->hasAnyRole(['JSPD-PENANDA','JSPD-URUSETIA']))
        {
            return redirect()->to(route('scorings.dashboard'));
        }

        $company['total'] = Company::query()->count();
        $user['total'] = User::query()->count();
        $user['admin'] = User::role('admin')->count(); ;
        $user['vendor'] = User::role('subscriber')->count(); ;

        // comment related
        $comment['total'] = Comment::query()->count();


        // video related
        $video['total'] = Video::query()->count();
        $video['success'] = Video::query()->where('duration','!=', 0)->count();
        $video['failed'] = Video::query()->where('duration','=', 0)->count();






        // state related
        $states = Company::distinct()
                    ->get(['states'])
                    ->map( function($val, $key)  {

                        //$val['count'] =12;
                        //dd($val->states);
                        $val['count'] = Company::query()
                        ->where('states', 'LIKE', '%'.$val->states.'%')
                        ->count();
                        return $val;
                    });
       // dd($states);

        $state['selangor'] = Company::query()
        ->where('states', 'LIKE', '%selangor%')
        ->count();


        //dd($total);

        // video related
        $video['total'] = Video::query()
        ->where('is_ready', true)
        ->count();

        $video['filesize'] = Video::query()
        ->where('is_ready', true)
        ->sum('filesize');

        $video['asset_size'] = Video::query()
        ->where('is_ready', true)
        ->sum('asset_size');

        $video['duration'] = Video::query()
        ->where('is_ready', true)
        ->sum('duration');

        $video['processing'] = QueueMonitor::query()
        //->where('is_ready', true)
        ->sum('time_elapsed');

        $video['playback'] = Statistics::query()
        //->where('is_ready', true)
        ->sum('duration');

       //dd($video);



        return view('home')->with(compact(

            'company',

            'comment',

            'video',
            'states',

        ));
    }


    function jobs(){
        return view('home.jobs');
    }
}

