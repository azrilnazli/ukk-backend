<?php
namespace App\Services\Screening;

use App\Models\ScreeningSigner;
use App\Models\ScreeningUrusetia;
use App\Models\ScreeningOwner;
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
        // 1044 taken from JspdAdmin
        return TenderSubmission::query()

            ->has('approved','>=', 2)
            ->has('scorings','=', 3)
            ->has('verifications','=', 2)
            ->whereHas('user.company.company_approvals', fn($query) =>
                $query->where('is_approved', true)
            )
           // ->whereIn('tender_detail_id',[1,2])
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )
            ->orderBy('id','desc')
            ->paginate($item)

            ->setPath(route('screening-signers.index'));
    }

    public function pendingTasks($item = 50)
    {

        // 1044 taken from JspdAdmin
        return TenderSubmission::query()

            ->has('approved','>=', 2)
            ->has('scorings','=', 3)
            ->has('verifications','=', 2)
            ->whereHas('user.company.company_approvals', fn($query) =>
                $query->where('is_approved', true)
            )
           // ->whereIn('tender_detail_id',[1,2])
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )
            // only list without owner
            ->doesntHave('screening_owner')
            ->orderBy('id','desc')
            ->paginate($item)

            ->setPath(route('screening-signers.pending-tasks'));
    }

    // find TenderSubmission that tasked to logged user ( urusetia-1)
    public function finishedTasks($item=50){
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
        // assigned to logged user via screening_urusetias
        //->has('screening_owner')
        ->whereHas('screening_owner', fn($query) =>
            $query->where('user_id', auth()->user()->id )
        )
        ->orderBy('id','desc')
        ->paginate($item)
        ->setPath(route('screening-signers.index'));
    }

    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

                        //  ->has('approved','>=', 2)
                        //  ->has('scorings','=', 3)
                        //  ->has('verifications','=', 2)
                        // // ->whereHas('user.company.company_approvals', fn($query) =>
                        //     $query->where('is_approved', true)
                        // )
                        //->whereIn('tender.tender_detail_id',[1,2])
                        // ->whereHas('tender.tender_detail', fn($query) =>
                        //      $query->whereIn('id', [1,2])
                        //  )

                        // ->with('tender')
                        // ->orWhereHas('tender.tender_detail', fn($query) =>
                        //     $query->where('id', 3)
                        // )

                        ->where(function ($query) use ($q)  {
                            $query->whereHas('tender.tender_detail', function ($query) {
                                $query->whereIn('id', [1,2]);
                            })
                            ->has('approved','>=', 2)
                            ->has('scorings','=', 3)
                            ->has('verifications','=', 2)
                            ->whereHas('user.company', function ($query) use ($q) {
                                $query->where('name', 'LIKE', '%' . $q . '%');
                            });

                        })

                        ->paginate(50)
                        ->setPath(route('screening-signers.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    public function storeOwner($tenderSubmission){

        $owner = ScreeningOwner::firstOrNew([
            'user_id' =>  auth()->user()->id ,
            'tender_submission_id' => $tenderSubmission->id
        ]);

        $owner->user_id = auth()->user()->id ;
        $owner->tender_submission_id = $tenderSubmission->id;
        $owner->save();


    }


    public function storeSigner($request, $tenderSubmission){
        // delete existing data in ScreeningSigner
        ScreeningSigner::query()
        ->where([
            'tender_submission_id' =>  $tenderSubmission->id,
        ])
        ->delete();

        // store signers
        collect($request)
        ->each( function($value , $key) use ($tenderSubmission){

            // populate new data
            $signer = ScreeningSigner::firstOrNew([
                'user_id' =>  $value ,
                'tender_submission_id' => $tenderSubmission->id
            ]);

            $signer->user_id = $value;
            $signer->tender_submission_id = $tenderSubmission->id;
            $signer->added_by = auth()->user()->id;
            $signer->save();
            //$signer->insertOrIgnore();
        });


    }

    public function storeUrusetia($request, $tenderSubmission){
        // delete existing data in ScreeningSigner
        ScreeningUrusetia::query()
        ->where([
            'tender_submission_id' =>  $tenderSubmission->id,
        ])
        ->delete();

        // store signers
        collect($request)
        ->prepend(auth()->user()->id) // add Owner as Urusetia
        ->each( function($value , $key) use ($tenderSubmission){

            // populate new data
            $urusetia = ScreeningUrusetia::firstOrNew([
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
