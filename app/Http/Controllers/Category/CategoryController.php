<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryController extends Controller
{
    var $category;

    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit',   ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);

         $this->category = new CategoryService;
    }

    public function index()
    {
        $data = $this->category->paginate();
        return view('categories.index')->with(compact('data'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreRequest $request)
    {
        $this->category->create($request);
        return redirect('categories')->with('success','Category created successfully');
    }


    public function edit(Category $category)
    {
        return view('categories.edit',compact(['category']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $this->category->update($request, $id);
        return redirect()->route('categories.index', $id)->with('success','Category updated.');
    }

    public function destroy($id)
    {
        $this->category->destroy($id);
        return redirect()->back()->with('success','Category deleted.');
    }
}