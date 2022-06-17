<?php 
class TenderDetail
{
    public static method routes()
    {
        use App\Http\Controllers\tender\TenderDetailController;
        Route::get('/tender-details', [TenderDetailController::class, 'index'])->name('tender-details.index');
        Route::get('/tender-details/search', [TenderDetailController::class, 'search'])->name('tender-details.search');
        Route::get('/tender-details/create', [TenderDetailController::class,'create'])->name('tender-details.create');
        Route::get('/tender-details/{role}/edit', [TenderDetailController::class,'edit'])->name('tender-details.edit');
        Route::put('/tender-details/{role}/edit', [TenderDetailController::class,'update'])->name('tender-details.update');
        Route::delete('/tender-details/{role}', [TenderDetailController::class, 'delete'])->name('tender-details.destroy');
    }
}
