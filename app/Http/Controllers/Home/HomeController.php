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


        //$roles = auth()->user()->getRoleNames();

        if(Auth::user()->hasRole('subscriber'))
        {
            // do something
            Auth::logout();
            Session::flush();
            return redirect()->to('https://ukk.rtm.gov.my');
        }


        // $users = null;

        // $users = User::query()
        // ->orderBy('id','desc')
        // ->limit(5)
        // ->get();

        // $requested = Company::query()
        // ->orderBy('updated_at','desc')
        // ->where('is_completed', true)
        // ->limit(5)
        // ->get();

        // $rejected = Company::query()
        // ->orderBy('updated_at','desc')
        // ->where('is_completed', false)
        // ->where('is_rejected', true)
        // ->limit(5)
        // ->get();

        // $approved = Company::query()
        // ->orderBy('updated_at','desc')
        // ->where('is_completed', true)
        // ->where('is_approved', true)
        // ->limit(5)
        // ->get();

        $resubmit = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_rejected', true)
        ->limit(5)
        ->get();

        // $proposals = TenderSubmission::query()
        // ->orderBy('updated_at','desc')
        // ->limit(5)
        // ->get();

        // user related
        $user['total'] = User::query()->count();
        $user['admin'] = User::role('admin')->count(); ;
        $user['vendor'] = User::role('subscriber')->count(); ;

        // comment related
        $comment['total'] = Comment::query()->count();


        // video related
        $video['total'] = Video::query()->count();
        $video['success'] = Video::query()->where('duration','!=', 0)->count();
        $video['failed'] = Video::query()->where('duration','=', 0)->count();


        // proposal related
        $proposal['total'] = TenderSubmission::query()
                                ->whereHas('user.company', fn($query) =>
                                        $query->where('is_approved', true)
                                    )
                                ->count();

        //$proposal['pdf_only'] = TenderSubmission::query()->where('is_pdf_cert_uploaded','=', true)->count();
        //$proposal['video_only'] = TenderSubmission::query()->where('video_id','!=', 0)->count();
        $proposal['both'] = TenderSubmission::query()->where('is_pdf_cert_uploaded','=', 1)->where('video_id','!=', 0)->count();

        $proposal['pdf_only'] = TenderSubmission::query()
        ->where('is_pdf_cert_uploaded','=', true)
        ->count();

        $proposal['video_only'] = TenderSubmission::query()
        ->whereHas('video', fn($query) =>
            $query->where('is_ready', true)
        )
        ->count();

        $proposal['sambung_siri'] = TenderSubmission::query()
        ->whereHas('tender', fn($query) =>
            $query->where('type', 'SAMBUNG SIRI')
        )
        ->count();

        $proposal['swasta'] = TenderSubmission::query()
        ->whereHas('tender', fn($query) =>
            $query->where('type', 'SWASTA')
        )
        ->count();


        // company related
        $company['total'] = Company::query()->count();

        $company['pending'] = Company::query()
        ->where('is_completed', true)
        ->where('is_rejected', false)
        ->where('is_approved', false)
        ->count();

        $company['rejected'] = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', false)
        ->where('is_rejected', true)
        ->count();

        $company['approved'] = Company::query()
        ->where('is_completed', true)
        ->where('is_approved', true)
        ->count();

        $company['resubmit'] = Company::query()
        ->where('is_completed', true)
        ->where('is_rejected', true)
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
            'user',
            'company',
            'proposal',
            'comment',
            'resubmit',
            'video'
        ));
    }


    function jobs(){
        return view('home.jobs');
    }
}
