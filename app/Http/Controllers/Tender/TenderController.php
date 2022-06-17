<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\Tender;
use Illuminate\Http\Request;
use App\Services\TenderService;
use App\Http\Requests\Tender\StoreTenderRequest;
use App\Http\Requests\Tender\UpdateTenderRequest;

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

    public function index()
    {
        $tenders = $this->tender->paginate();
        return view('tenders.index')->with(compact('tenders'));
    }

    public function search(Request $request){
   
        $tenders = $this->tender->search($request);
        return view('tenders.index')->with(compact('tenders'));
    }

    public function create()
    {
        $types = Tender::types(); // tender types
        $languages = Tender::get_languages();
        $channels = Tender::channels();
        return view('tenders.create', compact('languages','channels','types'));
    }

    public function store(StoreTenderRequest $request)
    {
        $this->tender->create($request);
        return redirect('tenders')->with('success','Tender created successfully');
    }

    public function edit(Tender $tender)
    {

        $types = Tender::types(); // tender types
        $languages = Tender::get_languages();
        $channels = Tender::channels();
        return view('tenders.edit',compact('tender','languages','channels','types'));
    }

    public function update(UpdateTenderRequest $request, $id)
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