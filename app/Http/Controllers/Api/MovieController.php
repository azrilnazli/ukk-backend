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

use Route;

class MovieController extends Controller
{
    use ApiResponser;

    static function routes(){
        // movies
        Route::get('/movies', [MovieController::class, 'index']);
        Route::post('/movies/statistics', [MovieController::class, 'store']);


        Route::get('/movie/{id}/play', [MovieController::class, 'show']); //test

        // route for HLS playlist request
        Route::get('/movie/{video}/{playlist}/{token}', function (  $video, $playlist, $token ) {

            return FFMpeg::dynamicHLSPlaylist()
                // http://admin.test/storage/streaming/15/m3u8/playlist.m3u8 --> master playlist
                ->fromDisk("streaming") // public storage for m3u8
                ->open("$video/m3u8/$playlist")

                // secret key resolver
                ->setKeyUrlResolver( function($key) use ($video, $token) {
                    return route('api.secret.key',['video' => $video, 'key' => $key, 'access_token' => $token]);
                })
                // requeste will look for referenced playlist
                // eg playlist_0_400.m3u8 , playlist_0_500.m3u8
                ->setPlaylistUrlResolver( function($playlist) use ($video, $token) {
                    return route('api.movie', ['video' => $video, 'playlist' => $playlist, 'token' => $token, 'access_token' => $token]);
                })
                // actual disk for media
                ->setMediaUrlResolver(function($media) use ($video, $token) {
                    return Storage::disk('streaming')->url($video .'/m3u8/'. $media . '?access_token=' . $token);
                });
        })->name('api.movie')->middleware('auth:sanctum');



        # secret key
        // the get url can be change and will be dynamically
        // alterred in playlist file
        Route::get('/storage/streaming/{video}/m3u8/{key}', function($video,$key){
            return Storage::disk('assets')->download( $video .'/secrets/'. $key);
        })->name('api.secret.key')->middleware('auth:sanctum');
    }

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
            //Log::info($message);
            //Log::info($header);
        } else {
            $message = 'guest';
           // Log::info($message);
            //Log::info($header);
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
