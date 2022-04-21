<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\CompanyController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->post('/auth/register', [AuthController::class, 'register']);
Route::middleware('guest')->post('/auth/login', [AuthController::class, 'login']);
Route::middleware('guest')->post('/password/email', [AuthController::class, 'email']);
Route::middleware('guest')->post('/password/reset', [AuthController::class, 'reset_password']);

Route::group(['middleware' => ['auth:sanctum','throttle:none'] ], function () {
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });


    // movies
    Route::get('/movies', [MovieController::class, 'index']);
    Route::post('/movies/statistics', [MovieController::class, 'store']);
   
    // user
    Route::post('/user/update', [AuthController::class, 'update']);
    Route::get('/user/my_account', [AuthController::class, 'my_account']);
    Route::post('/user/check_password', [AuthController::class, 'check_password']);
    Route::post('/user/new_password', [AuthController::class, 'new_password']);
    Route::get('/user/statistics', [MovieController::class, 'statistics']);

    // company
    Route::get('/company/show_profile', [CompanyController::class, 'show_profile']);

    // system
    Route::post('/auth/logout', [AuthController::class, 'logout']);
   
    
});

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
