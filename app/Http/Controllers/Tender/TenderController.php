<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\TenderCategory;
use App\Models\Tender;
use Illuminate\Http\Request;
use App\Services\TenderService;
use App\Http\Requests\Tender\Tender\StoreRequest;
use App\Http\Requests\Tender\Tender\UpdateRequest;
use Route;

class TenderController extends Controller
{
    var $tender;

    function __construct(){

        $this->middleware('permission:tender-list|tender-create|tender-edit|tender-delete', ['only' => ['index','show']]);
        $this->middleware('permission:tender-create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:tender-delete', ['only' => ['destroy']]);

        $this->tender = new TenderService;
    }

    static function routes()
    {
        Route::get('/tenders/search', [TenderController::class, 'search'])->name('tenders.search');
        Route::resource('tenders', TenderController::class );
    }

    public function index()
    {
        $tenders = $this->tender->paginate();
        return view('tenders.index')->with(compact('tenders'));
    }

    public function search(Request $request)
    {
        $tenders = $this->tender->search($request);
        return view('tenders.index')->with(compact('tenders'));
    }

    public function create()
    {
        $tenderCategories = TenderCategory::all();
        $types = Tender::types(); // tender types
        $languages = Tender::get_languages();
        $channels = Tender::channels();
        return view('tenders.create', compact('languages','channels','types','tenderCategories'));
    }

    public function store(StoreRequest $request)
    {
        $this->tender->create($request);
        return redirect('tenders')->with('success','Tender created successfully');
    }

    public function edit(Tender $tender)
    {

        $tenderCategories = TenderCategory::all();
        $types = Tender::types(); // tender types
        $languages = Tender::get_languages();
        $channels = Tender::channels();
        return view('tenders.edit',compact('tender','languages','channels','types','tenderCategories'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->tender->update($request, $id);
        return redirect()->route('tenders.index', $id)->with('success','Tender updated.');
    }

    public function destroy($id)
    {
        $this->tender->destroy($id);
        return redirect()->back()->with('success','Tender deleted.');
    }
}
