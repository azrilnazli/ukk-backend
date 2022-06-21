<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ContentController extends Controller
{
    function __construct(){
        $this->service = new \App\Services\CompanyApprovalService;
    }

    static function routes()
    {
        Route::get('/contents/{module}', [ContentController::class, 'get_content'])->name('contents.module');
    }

    public function get_content($module)
    {

        $result = Content::query()->where('module',$module)->first();
        // JSON response 200
        return response([
            'title' =>  !is_null($result) ? $result->title : null ,
            'content' =>  !is_null($result) ? $result->content : null ,
        ],200);
    }

}
