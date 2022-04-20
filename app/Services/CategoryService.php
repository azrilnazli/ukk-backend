<?php 
namespace App\Services;

use App\Models\Category;
use Auth;

class CategoryService {

    // contstructor
    public function __construct(){
       
    }

    public function paginate($items = 50){
        return Category::orderBy('id','desc')->paginate($items)->setPath('categories');
    }

    public function search($request)
    {
        $query = $request->input('query');        
        return Category::where([['title', 'like', "{$query}%"]])
                        ->paginate(10)->setPath('categories');
        
    }

    public function create($request){
        return Category::create([
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'description' => $request['description'],
            ]);
    }

    public function find($id){
        return Category::find($id);
    }
    
    public function update($request, $id){
        return Category::where('id',$id)->update([
            'title' => $request['title'],
            'description' => $request['description'],
        ]); 
    }

    public function destroy($id){
        return Category::where('id',$id)->delete();
    }
        
} 