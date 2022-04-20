<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;

use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;
use Log;

use DB;
use App\Models\Video;
use App\Models\Statistics;

use App\Actions\Stats;
use App\Actions\Logger;
use App\Actions\Utilities;

class MovieController extends Controller
{
    use ApiResponser;
    
    function index(){
    //return response()->json(Video::all());

       $videos = Video::paginate(8)
                ->setPath('');
        
       return response()->json($videos);
    }

    function show(Request $request)
    {

        $header = $request->header();
        if(  Auth('sanctum')->check() )
        {
            $message = 'authenticated user';
            Log::info($message);
            Log::info($header);
        } else {
            $message = 'guest';
            Log::info($message);
            Log::info($header);
        }

        return response()->json($message);

    }

    // store video usage in statistics
    function store(Request $request)
    {

        $logger = new Logger($request);
        $result = $logger->storeVideoPlayerUsage($request);
        $message = ['message' => $result ];

        return response()->json($message);
    }


    function statistics(Request $request){

        // get userid from given token
        // $access_token = $request->header('Authorization'); // will return tokenable_id == user_id
        // $user_id = $this->getUserId($access_token);
        $user_id = $request->user()->id; // provided by Sanctum
        $stats = new Stats($user_id);
        $utilities = new Utilities();

        $message = [
            'duration'  =>  collect( $stats->all() )->sum('duration'),
            'user_id'   =>  $user_id,
            'videos'    =>  $stats->all(),
            'volume'    =>  $utilities->formatBytes( collect( $stats->all() )->sum('bytes') ),
        ];

        return response()->json($message);
    }

}
