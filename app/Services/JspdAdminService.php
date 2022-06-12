<?php
namespace App\Services;

use App\Models\TenderSubmission;
use App\Models\Approval;
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

    public function approved($item = 50)
    {
        return TenderSubmission::query()

            ->has('approved','=', 2)
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

                        ->orWhereHas('user.approved_company', fn($query) =>
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

    public function store($request){
        $approval = Approval::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'tender_submission_id' => $request['tender_submission_id']
        ]);

        $approval->user_id = $request['user_id'];
        $approval->is_approved = $request['is_approved'];
        $approval->save();

        return $approval;
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
