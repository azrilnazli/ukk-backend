<?php
namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
//use Auth;
use App\Models\TenderRequirement;
//use Illuminate\Http\Request;
use App\Services\TenderRequirementService;
use App\Http\Requests\Tender\TenderRequirement\StoreRequest;
use App\Http\Requests\Tender\TenderRequirement\UpdateRequest;
use Illuminate\Support\Facades\Route;

class TenderRequirementController extends Controller
{
    var $service;

    function __construct(){
        $this->middleware('permission:tender-requirement-list|tender-requirement-create|tender-requirement-edit|tender-requirement-delete', ['only' => ['index','show']]);
        $this->middleware('permission:tender-requirement-create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-requirement-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:tender-requirement-delete', ['only' => ['destroy']]);

        $this->service = new TenderRequirementService;
    }

    static function routes() {

        Route::get('/tender-requirements', [TenderRequirementController::class, 'index'])->name('tender-requirements.index');
        Route::get('/tender-requirements/search', [TenderRequirementController::class, 'search'])->name('tender-requirements.search');
        Route::get('/tender-requirements/create', [TenderRequirementController::class,'create'])->name('tender-requirements.create');
        Route::post('/tender-requirements/store', [TenderRequirementController::class,'store'])->name('tender-requirements.store');
        Route::get('/tender-requirements/{tenderRequirement}/edit', [TenderRequirementController::class,'edit'])->name('tender-requirements.edit');
        Route::put('/tender-requirements/{tenderRequirement}/edit', [TenderRequirementController::class,'update'])->name('tender-requirements.update');
        Route::delete('/tender-requirements/{tenderRequirement}', [TenderRequirementController::class, 'destroy'])->name('tender-requirements.destroy');
    }


    public function index()
    {
        $tenders =$this->service->paginate();
        return view('tender_requirements.index')->with(compact('tenders'));
    }

    public function search(Request $request){

        $tenders =$this->service->search($request);
        return view('tender_requirements.index')->with(compact('tenders'));
    }

    public function create()
    {
        // get available requiremnents
        return view('tender_requirements.create');
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('tender-requirements.index')->with('success','Tender Requirement created successfully');
    }

    public function edit(TenderRequirement $tenderRequirement)
    {
        return view('tender_Requirements.edit',compact('tenderRequirement'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->service->update($request, $id);
        return redirect()->route('tender-requirements.index', $id)->with('success','Tender Requirement updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back()->with('success','Tender Requirement deleted successfully.');
    }
}
