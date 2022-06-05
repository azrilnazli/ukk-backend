<?php
namespace App\Services;

use App\Models\Signer;
use App\Models\TenderSubmission;
use Auth;

class SignerService {


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
            ->setPath(route('tender_submissions.index'));
    }

    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

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
                        ->setPath(route('tender_submissions.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }


    public function store($request,$type, $tenderSubmission){
        // delete existing data
        Signer::query()
        ->where([
            'tender_submission_id' =>  $tenderSubmission->id,
            'type' => $type
        ])
        ->delete();

        // store signers
        $signers = collect($request)
                    ->each( function($value , $key) use ($tenderSubmission, $type){

                        // populate new data
                        $signer = Signer::firstOrNew([
                            'user_id' =>  $value ,
                            'type' => $type,
                            'tender_submission_id' => $tenderSubmission->id
                        ]);
                
                        $signer->user_id = $value;
                        $signer->type = $type;
                        $signer->tender_submission_id = $tenderSubmission->id;
                        $signer->added_by = auth()->user()->id;
                        $signer->save();
                    });                 
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
