<?php
namespace App\Services;

use App\Models\Content;
use Auth;

class ContentService {


    // contstructor
    public function __construct(){

    }


    public function paginate($item = 50)
    {
        return Content::query()

            // ->whereHas('user.company', fn($query) =>
            //     $query->where('is_approved', true)
            //     )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('contents.index'));
    }



    public function store($request){
        $request['user_id'] = auth()->user()->id;
        return Content::create($request->except(['_token','_method']));
    }

    public function find($id){
        return Content::find($id);
    }

    public function update($request, $id){
        return Content::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        return Content::where('id',$id)->delete();
    }

}
