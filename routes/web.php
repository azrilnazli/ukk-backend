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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::resource('users', UserController::class);
Route::get('/companies/requested', [App\Http\Controllers\CompanyController::class, 'requested'])->name('requested');
Route::get('/companies/is_approved', [App\Http\Controllers\CompanyController::class, 'is_approved'])->name('is_approved');
Route::get('/companies/is_pending', [App\Http\Controllers\CompanyController::class, 'is_pending'])->name('is_pending');
Route::get('/companies/is_rejected', [App\Http\Controllers\CompanyController::class, 'is_rejected'])->name('is_rejected');
Route::get('/companies/is_new', [App\Http\Controllers\CompanyController::class, 'is_new'])->name('is_new');
Route::get('/companies/is_resubmit', [App\Http\Controllers\CompanyController::class, 'is_resubmit'])->name('is_resubmit');

Route::resources([
    'users'   =>  App\Http\Controllers\UserController::class,
    'videos'  =>  App\Http\Controllers\VideoController::class,
    'categories'  =>  App\Http\Controllers\CategoryController::class,
    'companies'  =>  App\Http\Controllers\CompanyController::class,
]);

// companies


Route::resource('profile', App\Http\Controllers\ProfileController::class )->except([ 'create','destroy']);

Route::post('/videos/store_video', [App\Http\Controllers\VideoController::class, 'store_video'])->name('videos.store_video');
Route::get('/videos/{video}/progress', [App\Http\Controllers\VideoController::class, 'progress'])->name('videos.progress');
Route::get('/videos/{video}/status', [App\Http\Controllers\VideoController::class, 'status'])->name('videos.status');
Route::get('/videos/{video}/delayed_redirect', [App\Http\Controllers\VideoController::class, 'delayed_redirect'])->name('videos.delayed_redirect');


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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


