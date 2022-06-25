<?php
namespace App\Services;

use App\Models\TenderCategory;
use Auth;

class TenderCategoryService {


    // contstructor
    public function __construct(){

    }


    public function paginate($item = 50)
    {
        return TenderCategory::query()

            // ->whereHas('user.company', fn($query) =>
            //     $query->where('is_approved', true)
            //     )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('tender-details.index'));
    }

    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderCategory::query()

                    ->orWhereHas('user.company', fn($query) =>
                        $query->where('name', 'LIKE', '%' . $q . '%')
                        ->orWhere('email', 'LIKE', '%' . $q . '%')
                        ->orWhere('id', 'LIKE', '%' . $q . '%')
                        ->orWhere('phone', 'LIKE', '%' . $q . '%')

                    )
                    ->orWhereHas('tender', fn($query) =>
                        $query->where('programme_category', 'LIKE', '%' . $q . '%')
                        ->orWhere('type', 'LIKE', '%' . $q . '%')
                        ->orWhere('duration', 'LIKE', '%' . $q . '%')
                        ->orWhere('channel', 'LIKE', '%' . $q . '%')
                        ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                    )

                    ->paginate(50)
                    ->setPath(route('tender-details.search'));

                    $tenders->appends([
                        'query' => $q
                        ]);
        return $tenders;

    }

    public function store($request){
        $request['user_id'] = auth()->user()->id;
        return TenderCategory::create($request->except(['_token','_method']));
    }

    public function find($id){
        return TenderCategory::find($id);
    }

    public function update($request, $id){
        return TenderCategory::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        return TenderCategory::where('id',$id)->delete();
    }

}
