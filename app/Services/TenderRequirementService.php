<?php
namespace App\Services;

use App\Models\TenderRequirement;
use Auth;

class TenderRequirementService {


    // contstructor
    public function __construct(){

    }


    public function paginate($item = 50)
    {
        return TenderRequirement::query()

            // ->whereHas('user.company', fn($query) =>
            //     $query->where('is_approved', true)
            //     )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('tender-requirements.index'));
    }

    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderRequirement::query()

                    ->orWhereHas('user.company', fn($query) =>
                        $query->where('name', 'LIKE', '%' . $q . '%')
                        ->orWhere('email', 'LIKE', '%' . $q . '%')
                        ->orWhere('id', 'LIKE', '%' . $q . '%')
                        ->orWhere('phone', 'LIKE', '%' . $q . '%')

                    )
                    ->orWhereHas('tender', fn($query) =>
                        $query->where('tender_category', 'LIKE', '%' . $q . '%')
                        ->orWhere('type', 'LIKE', '%' . $q . '%')
                        ->orWhere('duration', 'LIKE', '%' . $q . '%')
                        ->orWhere('channel', 'LIKE', '%' . $q . '%')
                        ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                    )

                    ->paginate(50)
                    ->setPath(route('tender-requirements.search'));

                    $tenders->appends([
                        'query' => $q
                        ]);
        return $tenders;

    }

    public function store($request){
        $request['user_id'] = auth()->user()->id;
        return TenderRequirement::create($request->except(['_token','_method']));
    }

    public function find($id){
        return TenderRequirement::find($id);
    }

    public function update($request, $id){
        return TenderRequirement::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        return TenderRequirement::where('id',$id)->delete();
    }

}
