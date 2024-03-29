<?php
namespace App\Services\Pitching;

use App\Models\PitchingSigner;
use App\Models\PitchingUrusetia;
use App\Models\PitchingOwner;
use App\Models\TenderSubmission;
use Auth;

class ApprovalService {


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
            // that doesn't have any PitchingOwner
            ->doesntHave('pitching_owner')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('pitching-signers.index'));
    }

    public function pending_tasks($item = 50)
    {

            return TenderSubmission::query()
            ->sortable()

            // check if this company approved for this TenderDetail
            // TenderSubmission belongsTo TenderDetail
            // CompanyApproval belongsTo Company
            // ->whereHas('user.company.company_approvals', fn($query) =>
            //      $query->where('is_approved', true)
            //  )
            // approved by JSPD
            //->has('approval')
            // assigned to logged user via pitching_urusetias
            //->doesntHave('pitching_owner')
            ->whereHas('pitching_urusetias', fn($query) =>
                 $query->where('user_id', auth()->user()->id ) // belongTo logged Urusetia
             )
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
            ->setPath(route('pitching-signers.tasks'));
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
                        ->setPath(route('pitching-admins.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    public function storeOwner($tenderSubmission){

        $owner = PitchingOwner::firstOrNew([
            'user_id' =>  auth()->user()->id ,
            'tender_submission_id' => $tenderSubmission->id
        ]);

        $owner->user_id = auth()->user()->id ;
        $owner->tender_submission_id = $tenderSubmission->id;
        $owner->save();


    }


    public function storeSigner($request, $tenderSubmission){
        // delete existing data in PitchingSigner
        PitchingSigner::query()
        ->where([
            'tender_submission_id' =>  $tenderSubmission->id,
        ])
        ->delete();

        // store signers
        collect($request)
        ->each( function($value , $key) use ($tenderSubmission){

            // populate new data
            $signer = PitchingSigner::firstOrNew([
                'user_id' =>  $value ,
                'tender_submission_id' => $tenderSubmission->id
            ]);

            $signer->user_id = $value;
            $signer->tender_submission_id = $tenderSubmission->id;
            $signer->added_by = auth()->user()->id;
            $signer->save();
        });


    }

    public function storeUrusetia($request, $tenderSubmission){
        // delete existing data in PitchingSigner
        PitchingUrusetia::query()
        ->where([
            'tender_submission_id' =>  $tenderSubmission->id,
        ])
        ->delete();

        // store signers
        collect($request)
        ->prepend(auth()->user()->id) // add Owner as Urusetia
        ->each( function($value , $key) use ($tenderSubmission){

            // populate new data
            $urusetia = PitchingUrusetia::firstOrNew([
                'user_id' =>  $value ,
                'tender_submission_id' => $tenderSubmission->id
            ]);

            $urusetia->user_id = $value;
            $urusetia->tender_submission_id = $tenderSubmission->id;
            $urusetia->added_by = auth()->user()->id;
            $urusetia->save();
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
