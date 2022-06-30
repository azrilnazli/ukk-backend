<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// FE Site Contents
\App\Http\Controllers\Api\ContentController::routes();

// Auth Guest
\App\Http\Controllers\Api\AuthController::guestRoutes();

// Movie
\App\Http\Controllers\Api\MovieController::routes();

// MP4
Route::get('/video/{video}/play', function($video){
    return Storage::disk('assets')->download( $video .'/original.mp4');
})->name('api.original_video')->middleware('guest');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum','throttle:none'] ], function () {

    // TenderSubmission
    \App\Http\Controllers\Api\TenderSubmissionController::routes();

    // TenderDetail
    \App\Http\Controllers\Api\TenderDetailController::routes();

    // CompanyApproval
    \App\Http\Controllers\Api\CompanyApprovalController::routes();

    // CompanyProposal
    \App\Http\Controllers\Api\CompanyProposalController::routes();

    // Tender
    \App\Http\Controllers\Api\TenderController::routes();

    // Video
    \App\Http\Controllers\Api\VideoController::routes();

    // Company
    \App\Http\Controllers\Api\CompanyController::routes();

    // Auth
    \App\Http\Controllers\Api\AuthController::routes();

});

