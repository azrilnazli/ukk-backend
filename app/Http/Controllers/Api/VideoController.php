<?php
namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Services\VideoService;

use App\Models\Video;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route;

class VideoController extends Controller
{

    function __construct()
    {
        //$this->video = new VideoService;
    }

    static function routes(){

        Route::get('/videos/{video}/metadata', [VideoController::class, 'show']);
        Route::get('/videos/{video}/status', [VideoController::class, 'status']);

        Route::get('/video/encoding_status', [VideoController::class, 'encoding_status']); // API
        Route::get('/video/failed_status', [VideoController::class, 'failed_status']); // API
        Route::get('/video/{video}/conversion_progress', [\App\Http\Controllers\Video\VideoController::class, 'conversion_progress']);
        Route::get('/video/{video}/is_playable', [\App\Http\Controllers\Video\VideoController::class, 'is_playable']);

    }

    public function show(Video $video)
    {

        $company = \App\Models\Company::where('user_id', auth()->user()->id )->first();
        if(is_null($company)){
            // return response as JSON
            return response([
                'status' => false // return as boolean
            ]);
        }

        return response([
            'status' => true, // return as boolean
            'video' => $video
        ]);

    }

    function encoding_status(){

        // query videos where is_processing = true
        $collection = Video::query()
                    //->select('id','original_filename')
                    ->where('is_processing', true)
                    ->where('is_failed', false)
                    ->get()
                    ->map( function($val, $key)  {

                        if(Storage::disk('assets')->exists($val->id . "/progress_all.txt")) {
                            $val['progress'] =  Storage::disk('assets')
                                                ->get( $val->id . "/progress_all.txt" );
                            return $val;
                        }
                    })
                    ->toJson();

        return response()->json([
            'message' => 'request accepted',
            'encoding' => $collection,
            'count' => Video::query()->where('is_processing', true)->count()
        ]);
    }

    function failed_status(){

        // query videos where is_processing = true
        $collection = Video::query()
                    ->select('id','original_filename')
                    ->where('is_processing', true)
                    ->where('is_failed', true)
                    ->get()
                    ->map( function($val, $key)  {

                        if(Storage::disk('assets')->exists($val->id . "/progress_all.txt")) {
                            $val['progress'] =  Storage::disk('assets')
                                                ->get( $val->id . "/progress_all.txt" );
                            return $val;
                        }
                    })
                    ->toJson();

        return response()->json([
            'message' => 'request accepted',
            'encoding' => $collection,
            'count' => Video::query()->where('is_processing', true)->count()
        ]);
    }

}
