<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CompanyProposalController;
use App\Http\Controllers\Api\TenderController;
use App\Http\Controllers\Api\VideoController;


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

    // TenderDetail
    \App\Http\Controllers\Api\TenderDetailController::routes();

    // tenders
    Route::get('/tenders/sambung_siri', [TenderController::class, 'sambung_siri']);
    Route::get('/tenders/swasta', [TenderController::class, 'swasta']);
    Route::get('/tenders/{type}/get_tenders', [TenderController::class, 'get_tenders']);
    Route::get('/tender/{id}', [TenderController::class, 'show']);
    Route::get('/proposal/show/{tender_id}', [TenderController::class, 'show_proposal']);
    Route::post('/tender/update_proposal', [TenderController::class, 'update_proposal']);

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
    Route::post('/company/upload', [CompanyController::class, 'upload']);

    Route::get('/company/board_of_directors', [CompanyController::class, 'board_of_directors']);
    Route::get('/company/check_board_of_directors', [CompanyController::class, 'check_board_of_directors']);
    Route::post('/company/update_board_of_directors', [CompanyController::class, 'update_board_of_directors']);

    Route::get('/company/experiences', [CompanyController::class, 'experiences']);
    Route::get('/company/check_experiences', [CompanyController::class, 'check_experiences']);
    Route::post('/company/update_experiences', [CompanyController::class, 'update_experiences']);

    Route::get('/company/audit', [CompanyController::class, 'audit']);
    Route::get('/company/check_audit', [CompanyController::class, 'check_audit']);
    Route::post('/company/update_audit', [CompanyController::class, 'update_audit']);

    Route::get('/company/credit', [CompanyController::class, 'credit']);
    Route::get('/company/check_credit', [CompanyController::class, 'check_credit']);
    Route::post('/company/update_credit', [CompanyController::class, 'update_credit']);

    Route::get('/company/authorization_letter', [CompanyController::class, 'authorization_letter']);
    Route::get('/company/check_authorization_letter', [CompanyController::class, 'check_authorization_letter']);
    Route::post('/company/update_authorization_letter', [CompanyController::class, 'update_authorization_letter']);

    Route::get('/company/official_company_letter', [CompanyController::class, 'official_company_letter']);
    Route::get('/company/check_official_company_letter', [CompanyController::class, 'check_official_company_letter']);
    Route::post('/company/update_official_company_letter', [CompanyController::class, 'update_official_company_letter']);

    Route::get('/company/bumiputera', [CompanyController::class, 'bumiputera']);
    Route::get('/company/check_bumiputera', [CompanyController::class, 'check_bumiputera']);
    Route::post('/company/update_bumiputera', [CompanyController::class, 'update_bumiputera']);

    Route::get('/company/bank', [CompanyController::class, 'bank']);
    Route::get('/company/check_bank', [CompanyController::class, 'check_bank']);
    Route::post('/company/update_bank', [CompanyController::class, 'update_bank']);

    Route::get('/company/profile', [CompanyController::class, 'profile']);
    Route::get('/company/check_profile', [CompanyController::class, 'check_profile']);
    Route::post('/company/update_profile', [CompanyController::class, 'update_profile']);

    Route::get('/company/mof', [CompanyController::class, 'mof']);
    Route::get('/company/check_mof', [CompanyController::class, 'check_mof']);
    Route::post('/company/update_mof', [CompanyController::class, 'update_mof']);

    Route::get('/company/finas_fp', [CompanyController::class, 'finas_fp']);
    Route::get('/company/check_finas_fp', [CompanyController::class, 'check_finas_fp']);
    Route::post('/company/update_finas_fp', [CompanyController::class, 'update_finas_fp']);

    Route::get('/company/finas_fd', [CompanyController::class, 'finas_fd']);
    Route::get('/company/check_finas_fd', [CompanyController::class, 'check_finas_fd']);
    Route::post('/company/update_finas_fd', [CompanyController::class, 'update_finas_fd']);

    Route::get('/company/ssm', [CompanyController::class, 'ssm']);
    Route::get('/company/check_ssm', [CompanyController::class, 'check_ssm']);
    Route::post('/company/update_ssm', [CompanyController::class, 'update_ssm']);

    Route::get('/company/kkmm_syndicated', [CompanyController::class, 'kkmm_syndicated']);
    Route::get('/company/check_kkmm_swasta', [CompanyController::class, 'check_kkmm_swasta']);
    Route::post('/company/update_kkmm_syndicated', [CompanyController::class, 'update_kkmm_syndicated']);

    Route::get('/company/kkmm_swasta', [CompanyController::class, 'kkmm_swasta']);
    Route::get('/company/check_kkmm_syndicated', [CompanyController::class, 'check_kkmm_syndicated']);
    Route::post('/company/update_kkmm_swasta', [CompanyController::class, 'update_kkmm_swasta']);

    // administration
    Route::get('/company/check_for_approval', [CompanyController::class, 'check_for_approval']);
    Route::get('/company/check_is_completed', [CompanyController::class, 'check_is_completed']);
    Route::get('/company/get_comments', [CompanyController::class, 'get_comments']);
    Route::get('/company/check_approval_status', [CompanyController::class, 'check_approval_status']);
    Route::post('/company/request_for_approval', [CompanyController::class, 'request_for_approval']);

    // company proposals
    Route::post('/proposal/upload_video', [CompanyProposalController::class, 'upload_video']);
    Route::get('/proposal/{proposal_id}/get_video', [CompanyProposalController::class, 'get_video']);
    Route::post('/proposal/upload_pdf', [CompanyProposalController::class, 'upload_pdf']);
    Route::get('/proposal/{proposal_id}/get_pdf', [CompanyProposalController::class, 'get_pdf']);
    Route::get('/proposal/my_proposal', [CompanyProposalController::class, 'my_proposal']);
    Route::post('/proposal/destroy', [CompanyProposalController::class, 'destroy']);

    // video
    Route::get('/video/encoding_status', [VideoController::class, 'encoding_status'])->name('videos.encoding_status'); // API
    Route::get('/video/{video}/conversion_progress', [App\Http\Controllers\Video\VideoController::class, 'conversion_progress'])->name('videos.conversion_progress');
    Route::get('/video/{video}/is_playable', [App\Http\Controllers\Video\VideoController::class, 'is_playable'])->name('videos.is_playable');


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
