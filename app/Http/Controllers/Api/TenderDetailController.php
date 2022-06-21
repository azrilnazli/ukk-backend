<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Models\TenderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TenderDetailController extends Controller
{

    function __construct(){ }

    static function routes()
    {
        Route::get('/tender-details', [TenderDetailController::class, 'index'])->name('tender-details.index');
        Route::get('/tender-details/search', [TenderDetailController::class, 'search'])->name('tender-details.search');
        Route::get('/tender-details/create', [TenderDetailController::class,'create'])->name('tender-details.create');
        Route::post('/tender-details/store', [TenderDetailController::class,'store'])->name('tender-details.store');
        Route::get('/tender-details/{tenderDetail}/edit', [TenderDetailController::class,'edit'])->name('tender-details.edit');
        Route::put('/tender-details/{tenderDetail}/edit', [TenderDetailController::class,'update'])->name('tender-details.update');
        Route::delete('/tender-details/{tenderDetail}', [TenderDetailController::class, 'destroy'])->name('tender-details.destroy');
    }

    function index()
    {
        $tenders = TenderDetail::with('tender_requirements')->orderBy('id','DESC')->get();

        return response([
            'message' =>  !empty($tenders) ? 'success' : 'empty',
            'tenders' => $tenders,
        ]);
    }
}
