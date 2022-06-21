<?php
namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
//use Auth;
use App\Models\TenderCategory;
use App\Models\TenderDetail;
//use Illuminate\Http\Request;
use App\Services\TenderCategoryService;
use App\Http\Requests\Tender\TenderCategory\StoreRequest;
use App\Http\Requests\Tender\TenderCategory\UpdateRequest;
use Illuminate\Support\Facades\Route;

class TenderCategoryController extends Controller
{
    var $service;

    function __construct(){
        $this->middleware('permission:tender-category-list|tender-category-create|tender-category-edit|tender-category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:tender-category-create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-category-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:tender-category-delete', ['only' => ['destroy']]);

        $this->service = new TenderCategoryService;
    }

    static function routes() {

        Route::get('/tender-categories', [TenderCategoryController::class, 'index'])->name('tender-categories.index');
        Route::get('/tender-categories/search', [TenderCategoryController::class, 'search'])->name('tender-categories.search');
        Route::get('/tender-categories/create', [TenderCategoryController::class,'create'])->name('tender-categories.create');
        Route::post('/tender-categories/store', [TenderCategoryController::class,'store'])->name('tender-categories.store');
        Route::get('/tender-categories/{TenderCategory}/edit', [TenderCategoryController::class,'edit'])->name('tender-categories.edit');
        Route::put('/tender-categories/{TenderCategory}/edit', [TenderCategoryController::class,'update'])->name('tender-categories.update');
        Route::delete('/tender-categories/{TenderCategory}', [TenderCategoryController::class, 'destroy'])->name('tender-categories.destroy');
    }


    public function index()
    {
        $tenders = $this->service->paginate();
        return view('tender_categories.index')->with(compact('tenders'));
    }

    public function search(Request $request){

        $tenders =$this->service->search($request);
        return view('tender_categories.index')->with(compact('tenders'));
    }

    public function create()
    {
        // get available tenderDetails
        $tenderDetails = TenderDetail::all();
        return view('tender_categories.create',compact('tenderDetails'));
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('tender-categories.index')->with('success','Tender Category created successfully');
    }

    public function edit(TenderCategory $tenderCategory)
    {
        return view('tender_categories.edit',compact('tenderCategory'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->service->update($request, $id);
        return redirect()->route('tender-categories.index', $id)->with('success','Tender Category updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back()->with('success','Tender Category deleted successfully.');
    }
}
