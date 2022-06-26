<?php
namespace App\Services;

use App\Models\Company;
use App\Models\Comment;
use Auth;

class CompanyService {

    // contstructor
    public function __construct(){

    }

    public function paginate($items = 50){
        return Company::query()
            ->sortable()
            ->with('company_approvals','user.proposals')
            ->whereNotNull('name')
            ->orderBy('id','desc')
            ->paginate($items)
            ->setPath('companies');
    }

    // for requested company
    public function requested($items = 50){
        return Company::query()
            ->orderBy('updated_at','desc')
            ->where('is_completed', 1) // submmitted for approval
            ->paginate($items)
            ->setPath('companies');
    }

    public function search($request)
    {
        $query = $request->input('query');
        return Company::query()
                        ->where('name', 'like', "{$query}%")
                        ->orWhere('id', "{$query}%")
                        ->paginate(10)
                        ->setPath(route('companies.search'));
    }

    public function create($request){
        return Company::create([
                'user_id' => Auth::user()->id,
                'name' => $request['name'],
                'experiences' => $request['experiences'],
            ]);
    }

    public function find($id){
        return Company::query()->find($id);
    }

    public function update($request, $id){

        if($request->is_approved == 1 ){
            return Company::where('id',$id)->update([
                'is_approved' => true, // approve or reject
                'is_completed' => true, // approve or reject
                'is_rejected' => false,
            ]);
        } else {
            return Company::where('id',$id)->update([
                'is_rejected' => true, // approve or reject
                'is_completed' => false, // approve or reject
                'is_approved' => false,
            ]);
        }
    }

    public function get_comments($id){

        return Comment::query()
                ->where('company_id', $id)
                ->orderBy('id', 'desc')
                ->get();
    }

    public function add_comment($request, $company_id, $tender_detail_id){
        return Comment::query()
                ->create([
                    'user_id' => Auth::user()->id,
                    'company_id' => $company_id,
                    'tender_detail_id' => $tender_detail_id,
                    'message' => $request['message']
                ]);
    }

    public function destroy($id){
        return Company::where('id',$id)->delete();
    }

}
