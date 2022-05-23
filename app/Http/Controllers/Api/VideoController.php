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

class VideoController extends Controller
{

    function __construct()
    {
        //$this->video = new VideoService;
    }

    function encoding_status(){

        // query videos where is_processing = true
        $collection = Video::query()
                    ->select('id','original_filename')
                    ->where('is_processing', true)
                    ->get()
                    ->map( function($val, $key)  {
                        $val['progress'] =  Storage::disk('assets')
                                            ->get( $val->id . "/progress_all.txt" );
                        return $val;
                    })
                    ->toJson();

        return response()->json([
            'message' => 'request accepted',
            'encoding' => $collection,
            'count' => Video::query()->where('is_processing', true)->count()
        ]);
    }

}
