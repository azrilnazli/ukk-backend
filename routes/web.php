<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/companies/requested', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');

Route::get('/queue/jobs', [App\Http\Controllers\Home\HomeController::class, 'jobs'])->name('videos.jobs');

//Route::resource('users', UserController::class);
Route::get('/companies/search', [App\Http\Controllers\Company\CompanyController::class, 'search'])->name('companies.search');
Route::get('/companies/requested', [App\Http\Controllers\Company\CompanyController::class, 'requested'])->name('companies.requested');
Route::get('/companies/is_approved', [App\Http\Controllers\Company\CompanyController::class, 'is_approved'])->name('companies.is_approved');
Route::get('/companies/is_pending', [App\Http\Controllers\Company\CompanyController::class, 'is_pending'])->name('companies.is_pending');
Route::get('/companies/is_rejected', [App\Http\Controllers\Company\CompanyController::class, 'is_rejected'])->name('companies.is_rejected');
Route::get('/companies/is_new', [App\Http\Controllers\Company\CompanyController::class, 'is_new'])->name('companies.is_new');
Route::get('/companies/is_resubmit', [App\Http\Controllers\Company\CompanyController::class, 'is_resubmit'])->name('companies.is_resubmit');


// tender
Route::get('/tenders/search', [App\Http\Controllers\Tender\TenderController::class, 'search'])->name('tenders.search');

// tender submission
Route::get('/tender_submissions/search', [App\Http\Controllers\Tender\TenderSubmissionController::class, 'search'])->name('tender_submissions.search');

Route::get('/users/search', [App\Http\Controllers\User\UserController::class, 'search'])->name('users.search');

Route::get('/videos/failed', [App\Http\Controllers\Video\VideoController::class, 'failed'])->name('videos.failed');
Route::get('/videos/encoding_status', [App\Http\Controllers\Video\VideoController::class, 'encoding_status'])->name('videos.encoding_status');

Route::resources([
    'users'   =>  App\Http\Controllers\User\UserController::class,
    'videos'  =>  App\Http\Controllers\Video\VideoController::class,
    'categories'  =>  App\Http\Controllers\Category\CategoryController::class,
    'companies'  =>  App\Http\Controllers\Company\CompanyController::class,
    'tenders'  =>  App\Http\Controllers\Tender\TenderController::class,
    'tender_submissions'  =>  App\Http\Controllers\Tender\TenderSubmissionController::class,
]);

// companies


Route::resource('profile', App\Http\Controllers\Profile\ProfileController::class )->except([ 'create','destroy']);

Route::post('/videos/store_video', [App\Http\Controllers\Video\VideoController::class, 'store_video'])->name('videos.store_video');


Route::get('/videos/{video}/progress', [App\Http\Controllers\Video\VideoController::class, 'progress'])->name('videos.progress');
Route::get('/videos/{video}/status', [App\Http\Controllers\Video\VideoController::class, 'status'])->name('videos.status');
Route::get('/videos/{video}/delayed_redirect', [App\Http\Controllers\Video\VideoController::class, 'delayed_redirect'])->name('videos.delayed_redirect');
//  Route::get('/videos/{video}/conversion_progress', [App\Http\Controllers\Video\VideoController::class, 'conversion_progress'])->name('videos.conversion_progress');

// User Profiles
//Route::get('/profile', [App])

Route::prefix('jobs')->group(function () {
    Route::queueMonitor();
});

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




Auth::routes();

Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');


