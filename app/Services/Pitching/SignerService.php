<?php
namespace App\Services\Pitching;

use App\Models\Signer;
use App\Models\TenderSubmission;
use Auth;

class SignerService {


    // contstructor
    public function __construct(){

    }

    /* to list TenderSubmission
        that passed Approval from ketua JSPD
    */
    public function paginate($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()

            // check if this company approved for this TenderDetail
            // TenderSubmission belongsTo TenderDetail
            // CompanyApproval belongsTo Company
             ->whereHas('user.company.company_approvals', fn($query) =>
                 $query->where('is_approved', true)
             )
             // approved by JSPD
             ->has('approval')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('pitching-signers.index'));
    }

    // find TenderSubmission that tasked to logged user ( urusetia-1)
    public function tasks($item=50){
        return TenderSubmission::query()
            //->sortable()

            // check if this company approved for this TenderDetail
            // TenderSubmission belongsTo TenderDetail
            // CompanyApproval belongsTo Company
            // ->whereHas('user.company.company_approvals', fn($query) =>
            //      $query->where('is_approved', true)
            //  )

            // Owner of TenderSubmission
            ->whereHas(
                'owner',
                function($query)
                {
                    $query->where('added_by', auth()->user()->id );
                }
            )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('signers.tasks'));
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
                            $query->where('programme_category', 'LIKE', '%' . $q . '%')
                            ->orWhere('duration', 'LIKE', '%' . $q . '%')
                            ->orWhere('channel', 'LIKE', '%' . $q . '%')
                            ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                        )
                        ->orWhereHas('tender.tender_detail', fn($query) =>
                            $query->where('title', 'LIKE', '%' . $q . '%')
                        )

                        ->paginate(50)
                        ->setPath(route('signers.search'));

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


        // to add himself as urusetia
        if($type == 'urusetia'){

            // urusetia add himself
            $signer = Signer::firstOrNew([
                'user_id' =>  auth()->user()->id ,
                'tender_submission_id' => $tenderSubmission->id
            ]);

            $signer->user_id = auth()->user()->id;
            $signer->type = 'urusetia';
            $signer->tender_submission_id = $tenderSubmission->id;
            $signer->save();
        }
    }

    public function find($id){
        return TenderSubmission::find($id);
    }

    public function update($request, $id){
        // return Tender::where('id',$id)->update([
        //     'channel' => $request['channel'],
        //     'language' => $request['language'],
        //     'programme_code' => $request['programme_code'],
        //     'programme_category' => $request['programme_category'],
        //     'title' => $request['title'],
        //     'description' => $request['description'],
        // ]);

        return TenderSubmission::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        return TenderSubmission::where('id',$id)->delete();
    }

}
