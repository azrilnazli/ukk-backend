<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(); // Auth

Route::resource('profile', App\Http\Controllers\Profile\ProfileController::class )->except([ 'create','destroy']);
Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');
Route::get('/users/search', [App\Http\Controllers\User\UserController::class, 'search'])->name('users.search');

// companies
use App\Http\Controllers\Company\CompanyController;
Route::get('/companies/search', [CompanyController::class, 'search'])->name('companies.search');
Route::get('/companies/requested', [CompanyController::class, 'requested'])->name('companies.requested');
Route::get('/companies/is_approved', [CompanyController::class, 'is_approved'])->name('companies.is_approved');
Route::get('/companies/is_pending', [CompanyController::class, 'is_pending'])->name('companies.is_pending');
Route::get('/companies/is_rejected', [CompanyController::class, 'is_rejected'])->name('companies.is_rejected');
Route::get('/companies/is_new', [CompanyController::class, 'is_new'])->name('companies.is_new');
Route::get('/companies/is_resubmit', [CompanyController::class, 'is_resubmit'])->name('companies.is_resubmit');

// tender
Route::get('/tenders/search', [App\Http\Controllers\Tender\TenderController::class, 'search'])->name('tenders.search');

// tender submission
Route::get('/tender_submissions/search', [App\Http\Controllers\Tender\TenderSubmissionController::class, 'search'])->name('tender_submissions.search');

// roles
use App\Http\Controllers\User\RoleController;
Route::get('/roles', [RoleController::class, 'index'])->name('roles');
Route::get('/roles/create', [RoleController::class,'create'])->name('roles.create');
Route::post('/roles', [RoleController::class,'store'])->name('roles.store');
Route::get('/roles/{role}/edit', [RoleController::class,'edit'])->name('roles.edit');
Route::put('/roles/{role}/edit', [RoleController::class,'update'])->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'delete'])->name('roles.destroy');

use App\Http\Controllers\User\PermissionController;
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');


// roles controller
Route::get('/roles/controller/create', [RoleController::class, 'create_controller'])->name('roles.controller.create');
Route::get('/roles/controller/destroy', [RoleController::class, 'delete_controller'])->name('roles.controller.destroy');

// jobs
Route::get('/queue/jobs', [App\Http\Controllers\Home\HomeController::class, 'jobs'])->name('videos.jobs');
Route::prefix('jobs')->group(function () {
    Route::queueMonitor();
});

// TenderDetail
\App\Http\Controllers\tender\TenderDetailController::routes();

// TenderRequirement
\App\Http\Controllers\tender\TenderRequirementController::routes();

// TenderCategory
\App\Http\Controllers\tender\TenderCategoryController::routes();


// JSPD - scorings
use App\Http\Controllers\JSPD\ScoringController;
Route::get('/scorings', [ScoringController::class, 'index'])->name('scorings.index');
Route::get('/scorings/tasks', [ScoringController::class, 'tasks'])->name('scorings.tasks');
Route::get('/scorings/search', [ScoringController::class, 'search'])->name('scorings.search');
Route::get('/scorings/dashboard', [ScoringController::class, 'dashboard'])->name('scorings.dashboard');
Route::get('/scorings/create', [ScoringController::class,'create'])->name('scorings.create');
Route::get('/scorings/{company}/company', [ScoringController::class,'company'])->name('scorings.company');
Route::get('/scorings/{role}/edit', [ScoringController::class,'edit'])->name('scorings.edit');
Route::put('/scorings/{role}/edit', [ScoringController::class,'update'])->name('scorings.update');
Route::delete('/scorings/{role}', [ScoringController::class, 'delete'])->name('scorings.destroy');
Route::post('/scorings/{tenderSubmission}', [ScoringController::class,'store'])->name('scorings.store');
Route::post('/scorings/{tenderSubmission}/verification', [ScoringController::class,'store_verification'])->name('scorings.store_verification');
Route::get('/scorings/{tenderSubmission}', [ScoringController::class, 'show'])->name('scorings.show');
Route::get('/scorings/{tenderSubmission}/verify', [ScoringController::class, 'show_verify'])->name('scorings.show_verify');
Route::post('/scorings/{tenderSubmission}/verify', [ScoringController::class,'store_verify'])->name('scorings.store_verify');


// JSPD - signers
use App\Http\Controllers\JSPD\SignerController;
Route::get('/signers', [SignerController::class, 'index'])->name('signers.index');
Route::get('/signers/tasks', [SignerController::class, 'tasks'])->name('signers.tasks');
Route::get('/signers/search', [SignerController::class, 'search'])->name('signers.search');
Route::get('/signers/dashboard', [SignerController::class, 'dashboard'])->name('signers.dashboard');
Route::get('/signers/create', [SignerController::class,'create'])->name('signers.create');
Route::get('/signers/{role}/edit', [SignerController::class,'edit'])->name('signers.edit');
Route::put('/signers/{role}/edit', [SignerController::class,'update'])->name('signers.update');
Route::delete('/signers/{role}', [SignerController::class, 'delete'])->name('signers.destroy');
Route::get('/signers/{tenderSubmission}', [SignerController::class, 'show'])->name('signers.show');
Route::post('/signers/{tenderSubmission}', [SignerController::class,'store'])->name('signers.store');

// JSPD - admins
use App\Http\Controllers\JSPD\JspdAdminController;
Route::get('/jspd-admins', [JspdAdminController::class, 'index'])->name('jspd-admins.index');
Route::get('/jspd-admins/approved', [JspdAdminController::class, 'approved'])->name('jspd-admins.approved');
Route::get('/jspd-admins/failed', [JspdAdminController::class, 'failed'])->name('jspd-admins.failed');
Route::get('/jspd-admins/pending', [JspdAdminController::class, 'pending'])->name('jspd-admins.pending');
Route::get('/jspd-admins/search', [JspdAdminController::class, 'search'])->name('jspd-admins.search');
Route::get('/jspd-admins/dashboard', [JspdAdminController::class, 'dashboard'])->name('jspd-admins.dashboard');
Route::get('/jspd-admins/create', [JspdAdminController::class,'create'])->name('jspd-admins.create');
Route::get('/jspd-admins/{role}/edit', [JspdAdminController::class,'edit'])->name('jspd-admins.edit');
Route::put('/jspd-admins/{role}/edit', [JspdAdminController::class,'update'])->name('jspd-admins.update');
Route::delete('/jspd-admins/{role}', [JspdAdminController::class, 'delete'])->name('jspd-admins.destroy');
Route::get('/jspd-admins/{tenderSubmission}', [JspdAdminController::class, 'show'])->name('jspd-admins.show');
Route::post('/jspd-admins/{tenderSubmission}', [JspdAdminController::class,'store'])->name('jspd-admins.store');

// videos
use App\Http\Controllers\Video\VideoController;
Route::post('/videos/store_video', [VideoController::class, 'store_video'])->name('videos.store_video');
Route::get('/videos/{video}/progress', [VideoController::class, 'progress'])->name('videos.progress');
Route::get('/videos/{video}/status', [VideoController::class, 'status'])->name('videos.status');
Route::get('/videos/{video}/delayed_redirect', [VideoController::class, 'delayed_redirect'])->name('videos.delayed_redirect');
Route::get('/videos/failed', [App\Http\Controllers\Video\VideoController::class, 'failed'])->name('videos.failed');
Route::get('/videos/encoding_status', [App\Http\Controllers\Video\VideoController::class, 'encoding_status']);


Route::resources([
    'users'   =>  App\Http\Controllers\User\UserController::class,
    'videos'  =>  App\Http\Controllers\Video\VideoController::class,
    'categories'  =>  App\Http\Controllers\Category\CategoryController::class,
    'companies'  =>  App\Http\Controllers\Company\CompanyController::class,
    'tenders'  =>  App\Http\Controllers\Tender\TenderController::class,
    'tender_submissions'  =>  App\Http\Controllers\Tender\TenderSubmissionController::class,
]);


// route for HLS playlist request
Route::get('/assets/{video}/{playlist}', function ( $video, $playlist ) {

    return FFMpeg::dynamicHLSPlaylist()

        // http://admin.test/storage/streaming/15/m3u8/playlist.m3u8 --> master playlist
        ->fromDisk("streaming") // public storage for m3u8
        ->open("$video/m3u8/$playlist")
        // secret key resolver
        ->setKeyUrlResolver(function($key) use ($video) {
            return route('secret.key',['video' => $video, 'key' => $key]);
        })
        // requeste will look for referenced playlist
        // eg playlist_0_400.m3u8 , playlist_0_500.m3u8
        ->setPlaylistUrlResolver(function($playlist) use ($video) {
            return route('assets', ['video' => $video, 'playlist' => $playlist]);
        })
        # actual disk for media
        ->setMediaUrlResolver(function($media) use ($video) {
            return Storage::disk('streaming')->url($video .'/m3u8/'. $media);
        });
})->name('assets')->middleware('auth'); // {{ route('assets', ['video' => $data->id, 'playlist' => 'playlist.m3u8']) }}
// ->middleware('auth');
# secret key
// the get url can be change and will be dynamically
// alterred in playlist file
Route::get('/storage/streaming/{video}/m3u8/{key}', function($video,$key){
    return Storage::disk('assets')->download( $video .'/secrets/'. $key);
})->name('secret.key')->middleware('auth');
