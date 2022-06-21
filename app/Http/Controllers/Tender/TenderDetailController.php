<?php
namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use App\Models\TenderDetail;
use App\Models\TenderRequirement;
use App\Services\TenderDetailService;
use App\Http\Requests\Tender\TenderDetail\StoreRequest;
use App\Http\Requests\Tender\TenderDetail\UpdateRequest;
use Illuminate\Support\Facades\Route;

class TenderDetailController extends Controller
{
    var $service;

    function __construct(){
        $this->middleware('permission:tender-detail-list|tender-detail-create|tender-detail-edit|tender-detail-delete', ['only' => ['index','show']]);
        $this->middleware('permission:tender-detail-create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-detail-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:tender-detail-delete', ['only' => ['destroy']]);

        $this->service = new TenderDetailService;
    }

    static function routes() {

        Route::get('/tender-details', [TenderDetailController::class, 'index'])->name('tender-details.index');
        Route::get('/tender-details/search', [TenderDetailController::class, 'search'])->name('tender-details.search');
        Route::get('/tender-details/create', [TenderDetailController::class,'create'])->name('tender-details.create');
        Route::post('/tender-details/store', [TenderDetailController::class,'store'])->name('tender-details.store');
        Route::get('/tender-details/{tenderDetail}/edit', [TenderDetailController::class,'edit'])->name('tender-details.edit');
        Route::put('/tender-details/{tenderDetail}/edit', [TenderDetailController::class,'update'])->name('tender-details.update');
        Route::delete('/tender-details/{tenderDetail}', [TenderDetailController::class, 'destroy'])->name('tender-details.destroy');
    }


    public function index()
    {
        $tenders =$this->service->paginate();
        return view('tender_details.index')->with(compact('tenders'));
    }

    public function search(Request $request){

        $tenders =$this->service->search($request);
        return view('tender_details.index')->with(compact('tenders'));
    }

    public function create()
    {
        // get available requiremnents
        $requirements = TenderRequirement::all();
        return view('tender_details.create', compact('requirements'));
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('tender-details.index')->with('success','Tender Detail created successfully');
    }

    public function edit(TenderDetail $tenderDetail)
    {
        $requirements = TenderRequirement::all();
        return view('tender_details.edit',compact('tenderDetail','requirements'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->service->update($request, $id);
        return redirect()->route('tender-details.index', $id)->with('success','Tender Detail updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back()->with('success','Tender Detail deleted successfully.');
    }
}
