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
        $encoding = Video::query()
                    ->where('is_processing', true)
                    ->get()
                    ->map( function($val, $key){
                        //get processing value
                        return $val->status = $key;
                    })
                    ->toJson();

        return response([
            'message' => 'request accepted',
            'encoding' => $encoding
        ]);
    }

}
