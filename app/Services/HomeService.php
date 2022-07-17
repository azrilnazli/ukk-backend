<?php
namespace App\Services;

use App\Models\Category;
use Auth;

class HomeService {

    // contstructor
    public function __construct(){

    }

    function video(){
        // video related
        $video['total'] = \App\Models\Video::query()
        ->where('is_ready', true)
        ->count();

        $video['filesize'] = \App\Models\Video::query()
        ->where('is_ready', true)
        ->sum('filesize');

        $video['asset_size'] = \App\Models\Video::query()
        ->where('is_ready', true)
        ->sum('asset_size');

        $video['duration'] = \App\Models\Video::query()
        ->where('is_ready', true)
        ->sum('duration');

        $video['processing'] = \App\Models\QueueMonitor::query()
        //->where('is_ready', true)
        ->sum('time_elapsed');

        $video['playback'] = \App\Models\Statistics::query()
        //->where('is_ready', true)
        ->sum('duration');

        return $video;

        // video related
        // $video['total'] = Video::query()->count();
        // $video['success'] = Video::query()->where('duration','!=', 0)->count();
        // $video['failed'] = Video::query()->where('duration','=', 0)->count();
    }

    function proposal(){

       // proposal related
       $proposal['total'] = \App\Models\TenderSubmission::query()
       // ->whereHas('user.company', fn($query) =>
       //         $query->where('is_approved', true)
       //     )
       ->has('user.approved_company')
       ->count();

        $proposal['assigned'] = \App\Models\TenderSubmission::query()
        ->has('user.approved_company')
        ->where('added_by','!=',0)
        ->count();

        $proposal['signed'] = \App\Models\TenderSubmission::query()
        ->has('scorings','=', 3)
        ->count();

        $proposal['verified'] = \App\Models\TenderSubmission::query()
        ->has('verifications','=', 2)
        ->count();

        $proposal['approved'] = \App\Models\TenderSubmission::query()
        ->has('approval','=', 1)
        ->count();

        $proposal['signers'] = \App\Models\TenderSubmission::query()
        ->has('signers','=', 3)
        ->has('urusetias','=', 2)
        ->count();

        $proposal['success'] = \App\Models\TenderSubmission::query()
        ->has('scorings','=', 3)
        ->has('verifications','=', 2)
        ->has('approved','=', 2)
        ->count();

        $proposal['failed'] = \App\Models\TenderSubmission::query()
        ->has('scorings','=', 3)
        ->has('verifications','=', 2)
        ->has('failed','=', 2)
        ->count();

        $proposal['pending'] = \App\Models\TenderSubmission::query()
        ->has('scorings','!=', 3)
        ->has('verifications','!=', 2)
        ->count();

        return $proposal;
    }

}
