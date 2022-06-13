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

        
        $resubmit = Company::query()
        ->orderBy('updated_at','desc')
        ->where('is_completed', true)
        ->where('is_rejected', true)
        ->limit(5)
        ->get();



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
                                // ->whereHas('user.company', fn($query) =>
                                //         $query->where('is_approved', true)
                                //     )
                                ->has('user.approved_company')
                                ->count();

        $proposal['assigned'] = TenderSubmission::query()
                            ->has('user.approved_company')
                            ->where('added_by','!=',0)
                            ->count();        

        $proposal['signed'] = TenderSubmission::query()
                            ->has('scorings','=', 3)
                            ->count();        
                            
        $proposal['verified'] = TenderSubmission::query()
                            ->has('verifications','=', 2)
                            ->count();  

        $proposal['approved'] = TenderSubmission::query()
                            ->has('approval','=', 1)
                            ->count();  

        $proposal['signers'] = TenderSubmission::query()
                            ->has('signers','=', 3)
                            ->has('urusetias','=', 2)
                            ->count();  

        $proposal['success'] = TenderSubmission::query()
                            ->has('scorings','=', 3)
                            ->has('verifications','=', 2)
                            ->has('approved','=', 2)
                            ->count();  

        $proposal['failed'] = TenderSubmission::query()
                            ->has('scorings','=', 3)
                            ->has('verifications','=', 2)
                            ->has('failed','=', 2)
                            ->count();  

        $proposal['pending'] = TenderSubmission::query()
                            ->has('scorings','!=', 3)
                            ->has('verifications','!=', 2)
                            ->count();  


                            


        //$proposal['pdf_only'] = TenderSubmission::query()->where('is_pdf_cert_uploaded','=', true)->count();
        //$proposal['video_only'] = TenderSubmission::query()->where('video_id','!=', 0)->count();
        $proposal['both'] = TenderSubmission::query()
                            ->whereHas('user.company', fn($query) =>
                                $query->where('is_approved', true)
                             )
                             ->whereHas('video', fn($query) =>
                             $query->where('is_ready', true)
                         )
                            ->where('is_pdf_cert_uploaded','=', 1)
                            ->count();

        $proposal['pdf_only'] = TenderSubmission::query()
                                ->whereHas('user.company', fn($query) =>
                                    $query->where('is_approved', true)
                                )
                                ->where('is_pdf_cert_uploaded','=', true)
                                ->count();

        $proposal['video_only'] = TenderSubmission::query()
                                ->whereHas('video', fn($query) =>
                                    $query->where('is_ready', true)
                                )
                                ->whereHas('user.company', fn($query) =>
                                    $query->where('is_approved', true)
                                )
                                ->where('is_pdf_cert_uploaded','=', false)
                                ->count();

        $proposal['sambung_siri'] = TenderSubmission::query()
                                ->whereHas('tender', fn($query) =>
                                    $query->where('type', 'SAMBUNG SIRI')
                                )
                                ->whereHas('user.company', fn($query) =>
                                    $query->where('is_approved', true)
                                )
                                ->count();

        $proposal['swasta'] = TenderSubmission::query()
                                ->whereHas('tender', fn($query) =>
                                    $query->where('type', 'SWASTA')
                                )
                                ->whereHas('user.company', fn($query) =>
                                    $query->where('is_approved', true)
                                )
                                ->count();

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

       // tender related
       $tenders['sambung_siri'] = Tender::query()
       ->distinct()
       ->where('type','SAMBUNG SIRI')
       ->select('id','programme_code')
       ->orderBy('programme_code', 'ASC')
       ->get(['programme_code'])
       ->map( function($val, $key)  {

           $val['count'] = TenderSubmission::query()
           ->where('tender_id', $val->id)
           ->count();
           return $val;
       });

       $tenders['swasta'] = Tender::query()
       ->distinct()
       ->where('type','SWASTA')
       ->select('id','programme_code')
       ->orderBy('programme_code', 'ASC')
       ->get(['programme_code'])
       ->map( function($val, $key)  {

           $val['count'] = TenderSubmission::query()
           ->where('tender_id', $val->id)
           ->count();
           return $val;
       });


        return view('home')->with(compact(
            'user',
            'company',
            'proposal',
            'comment',
            'resubmit',
            'video',
            'states',
            'tenders'
        ));
    }


    function jobs(){
        return view('home.jobs');
    }
}
