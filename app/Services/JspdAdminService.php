<?php
namespace App\Services;

use App\Models\TenderSubmission;
use Auth;

class JspdAdminService {


    // contstructor
    public function __construct(){
    }

    public function paginate($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()
            ->whereHas('user.company', fn($query) =>
                $query->where('is_approved', true)
                )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('jspd-admins.index'));
    }

    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

                        ->whereHas('user.company', fn($query) =>
                            $query->where('is_approved', true)
                        )

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
                        ->setPath(route('jspd-admins.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    public function create($request){
        return TenderSubmission::create($request->except(['_token','_method']));
    }

    public function find($id){
        return TenderSubmission::find($id);
    }

    public function update($request, $id){
        return TenderSubmission::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        return TenderSubmission::where('id',$id)->delete();
    }

}
