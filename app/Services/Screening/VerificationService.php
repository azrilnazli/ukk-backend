<?php
namespace App\Services\Screening;

use App\Models\ScreeningVerification;
use App\Models\TenderSubmission;
use Auth;

class VerificationService {


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
            // that doesn't have any ScreeningOwner
            ->doesntHave('screening_owner')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-verifications.index'));
    }

    public function pendingTasks($item = 50)
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
            // assigned to logged user via screening_urusetias
            //->doesntHave('screening_owner')
            ->whereHas('screening_urusetias', fn($query) =>
                 $query->where('user_id', auth()->user()->id ) // belongTo logged Urusetia
             )
            ->doesntHave('screening_verification')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-signers.index'));
    }

    public function finishedTasks($item = 50)
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
            //->has('screening_verification')
            // assigned to logged user via screening_urusetias
            //->doesntHave('screening_owner')
            ->whereHas('screening_verification', fn($query) =>
                 $query->where('user_id', auth()->user()->id ) // belongTo logged Urusetia
             )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-signers.index'));
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
            ->setPath(route('screening-signers.tasks'));
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
                        ->setPath(route('screening-signers.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    public function store($request,$tenderSubmission){

        $verification = ScreeningVerification::firstOrNew([
            'user_id' =>  auth()->user()->id ,
            'tender_submission_id' => $tenderSubmission->id
        ]);

        $verification->user_id = auth()->user()->id ;
        $verification->tender_submission_id = $tenderSubmission->id;
        $verification->is_verified =  $request['is_verified'];
        $verification->save();

        return $verification;
    }

    public function find($id){
        return TenderSubmission::find($id);
    }

    public function destroy($id){
        return TenderSubmission::where('id',$id)->delete();
    }

}
