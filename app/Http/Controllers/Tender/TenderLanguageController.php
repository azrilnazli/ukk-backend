<?php
namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
//use Auth;
use App\Models\TenderLanguage;
//use Illuminate\Http\Request;
use App\Services\TenderLanguageService;
use App\Http\Requests\Tender\TenderLanguage\StoreRequest;
use App\Http\Requests\Tender\TenderLanguage\UpdateRequest;
use Illuminate\Support\Facades\Route;

class TenderLanguageController extends Controller
{
    var $service;

    function __construct(){
        $this->middleware('permission:tender-language-list|tender-language-create|tender-language-edit|tender-language-delete', ['only' => ['index','show']]);
        $this->middleware('permission:tender-language-create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-language-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:tender-language-delete', ['only' => ['destroy']]);

        $this->service = new TenderLanguageService;
    }

    static function routes() {

        Route::get('/tender-languages', [TenderLanguageController::class, 'index'])->name('tender-languages.index');
        Route::get('/tender-languages/search', [TenderLanguageController::class, 'search'])->name('tender-languages.search');
        Route::get('/tender-languages/create', [TenderLanguageController::class,'create'])->name('tender-languages.create');
        Route::post('/tender-languages/store', [TenderLanguageController::class,'store'])->name('tender-languages.store');
        Route::get('/tender-languages/{tenderLanguage}/edit', [TenderLanguageController::class,'edit'])->name('tender-languages.edit');
        Route::put('/tender-languages/{tenderLanguage}/edit', [TenderLanguageController::class,'update'])->name('tender-languages.update');
        Route::delete('/tender-languages/{tenderLanguage}', [TenderLanguageController::class, 'destroy'])->name('tender-languages.destroy');
    }


    public function index()
    {
        $tenders =$this->service->paginate();
        return view('tender_languages.index')->with(compact('tenders'));
    }

    public function search(Request $request){
        $tenders =$this->service->search($request);
        return view('tender_languages.index')->with(compact('tenders'));
    }

    public function create()
    {
        // get available requiremnents
        return view('tender_languages.create');
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('tender-languages.index')->with('success','Tender Language created successfully');
    }

    public function edit(TenderLanguage $tenderLanguage)
    {
        return view('tender_languages.edit',compact('tenderLanguage'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->service->update($request, $id);
        return redirect()->route('tender-languages.index', $id)->with('success','Tender Language updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back()->with('success','Tender Language deleted successfully.');
    }
}
