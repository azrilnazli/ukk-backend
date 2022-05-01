<?php 
namespace App\Services;

use App\Models\Company;
use Auth;

class CompanyService {

    // contstructor
    public function __construct(){
       
    }

    public function paginate($items = 50){
        return Company::query()
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
        return Company::where([['title', 'like', "{$query}%"]])
                        ->paginate(10)->setPath('companies');
        
    }

    public function create($request){
        return Company::create([
                'user_id' => Auth::user()->id,
                'name' => $request['name'],
                'experiences' => $request['experiences'],
            ]);
    }

    public function find($id){
        return Company::find($id);
    }
    
    public function update($request, $id){
        return Company::where('id',$id)->update([
            'is_approved' => $request['is_approved'],
         
        ]); 
    }

    public function destroy($id){
        return Company::where('id',$id)->delete();
    }
        
} 