<?php
namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
//use Auth;
use App\Models\Content;
//use Illuminate\Http\Request;
use App\Services\ContentService;
use App\Http\Requests\Content\StoreRequest;
use App\Http\Requests\Content\UpdateRequest;
use Illuminate\Support\Facades\Route;

class ContentController extends Controller
{
    var $service;

    function __construct(){
        $this->middleware('permission:content-list|content-create|content-edit|content-delete', ['only' => ['index','show']]);
        $this->middleware('permission:content-create', ['only' => ['create','store']]);
        $this->middleware('permission:content-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:content-delete', ['only' => ['destroy']]);

        $this->service = new ContentService;
    }

    static function routes() {

        Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
        Route::get('/contents/search', [ContentController::class, 'search'])->name('contents.search');
        Route::get('/contents/create', [ContentController::class,'create'])->name('contents.create');
        Route::post('/contents/store', [ContentController::class,'store'])->name('contents.store');
        Route::get('/contents/{content}/edit', [ContentController::class,'edit'])->name('contents.edit');
        Route::put('/contents/{content}/edit', [ContentController::class,'update'])->name('contents.update');
        Route::delete('/contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');
    }


    public function index()
    {
        $contents =$this->service->paginate();
        return view('contents.index')->with(compact('contents'));
    }

    public function search(Request $request){

        $contents =$this->service->search($request);
        return view('contents.index')->with(compact('contents'));
    }

    public function create()
    {
        // get available requiremnents
        return view('contents.create');
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('contents.index')->with('success','Content created successfully');
    }

    public function edit(Content $content)
    {
        return view('contents.edit',compact('content'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->service->update($request, $id);
        return redirect()->route('contents.index', $id)->with('success','Content updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back()->with('success','Content deleted successfully.');
    }
}
