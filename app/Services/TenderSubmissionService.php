<?php 
namespace App\Services;

use App\Models\TenderSubmission;
use Auth;

class TenderSubmissionService {

    // contstructor
    public function __construct(){
       
    }

    public function paginate($items = 50){
        return TenderSubmission::orderBy('id','desc')->paginate($items)->setPath('tender_submissions');
    }

    public function search($request)
    {
        // $query = $request->input('query');        
        // return Tender::where([['title', 'like', "{$query}%"]])
        //                 ->paginate(10)->setPath('tenders');
        $q = $request->input('query');
        $tenders = TenderSubmission::query()
                    ->where('title', 'LIKE', '%' . $q . '%')
                    ->orWhere('id', 'LIKE', '%' . $q . '%')
                    ->orWhere('description', 'LIKE', '%' . $q . '%')
                   
                    ->paginate(50);

        $tenders->appends(['search' => $q]);

        return $tenders;
        
    }

    public function create($request){
        // return Tender::create([
        //         'user_id' => Auth::user()->id,
        //         'channel' => $request['channel'],
        //         'language' => $request['language'],
        //         'programme_code' => $request['programme_code'],
        //         'tender_category' => $request['tender_category'],
        //         'title' => $request['title'],
        //         'description' => $request['description'],
        //     ]);

        return TenderSubmission::create($request->except(['_token','_method']));
    }

    public function find($id){
        return TenderSubmission::find($id);
    }
    
    public function update($request, $id){
        // return Tender::where('id',$id)->update([
        //     'channel' => $request['channel'],
        //     'language' => $request['language'],
        //     'programme_code' => $request['programme_code'],
        //     'tender_category' => $request['tender_category'],
        //     'title' => $request['title'],
        //     'description' => $request['description'],
        // ]); 

        return TenderSubmission::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        return TenderSubmission::where('id',$id)->delete();
    }
        
} 