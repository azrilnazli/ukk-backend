<?php

namespace App\Actions;
use Log;


class Utilities {

    // contstructor
    public function __construct(){
        //Log::info("Utilities initiated");
    }

    function secondsToMinute($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        //return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
        return $dtF->diff($dtT)->format('%i');
    }

    function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }


    function getUserId($sent_token = null){

        [$id, $token] = explode('|', $sent_token, 2);
        $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $token))->first();
        return $token_data->tokenable_id;

    }



}
