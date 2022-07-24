<?php
namespace App\Services\Pitching;

use App\Models\PitchingVerification;
use App\Models\TenderSubmission;
use Auth;

class AdminService {


    // contstructor
    public function __construct(){}


    // Total Proposal
    public function totalProposals()
    {
        // 1044 taken from JspdAdmin
        return TenderSubmission::query()
            // ->has('approved','>=', 2)
            // ->has('scorings','=', 3)
            // ->has('verifications','=', 2)
            // ->whereHas('user.company.company_approvals', fn($query) =>
            //     $query->where('is_approved', true)
            // )
            // ->whereIn('tender_detail_id',[1,2])
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )
            ->count();
    }

    // Approved Proposal
    public function approvedProposals()
    {
        // 1044 taken from JspdAdmin
        return TenderSubmission::query()

            ->has('pitching_scorings','=', 3)
            ->has('pitching_verification','=', 1)
            ->count();
    }

    // scores

    public function scores(){
        $scores = [
            'gagal' => ['bg' => 'danger','min' => 0,'max' => 79,],
            'biasa' => ['bg' => 'warning','min' => 80,'max' => 85],
            'sederhana_baik' => ['bg' => 'yellow','min' => 86,'max' => 90],
            'baik' => ['bg' => 'success','min' => 91,'max' => 95],
            'sangat_baik' => ['bg' => 'success','min' => 96,'max' => 100],
        ];

        //dd($ranges);
        $results = TenderSubmission::query()
        ->has('pitching_scorings','=', 3)
        ->has('pitching_verification','=', 1)
        ->get()
        ->map( function($value, $key){
            $total = null;
            foreach($value->pitching_scorings as $score){
                $total += $score->total_score;
            }

            //$proposal[$value->id] = $total;
            //return $proposal;
            return round(($total/300)*100);
        })->toArray();

        foreach($scores as $index => $ranges){
            $min = $ranges['min'];
            $max = $ranges['max'];
            foreach($results as $result){
                //echo $result;
                if($result > $min && $result <= $max){
                    $scores[$index]['score'][] = $result;
                }
            }
        }

        return $scores;

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
            // ->whereHas('user.company.company_approvals', fn($query) =>
            //      $query->where('is_approved', true)
            //  )
            // // approved by JSPD
            // ->has('approval')
            // that doesn't have any PitchingOwner
            ->has('pitching_owner')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('pitching-admins.index'));
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
            // assigned to logged user via pitching_urusetias
            //->doesntHave('pitching_owner')
            ->whereHas('pitching_urusetias', fn($query) =>
                 $query->where('user_id', auth()->user()->id ) // belongTo logged Urusetia
             )
            ->doesntHave('pitching_verification')
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('pitching-signers.index'));
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
            //->has('pitching_verification')
            // assigned to logged user via pitching_urusetias
            //->doesntHave('pitching_owner')
            ->whereHas('pitching_verification', fn($query) =>
                 $query->where('user_id', auth()->user()->id ) // belongTo logged Urusetia
             )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('pitching-signers.index'));
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
                        ->setPath(route('pitching-signers.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    public function store($request,$tenderSubmission){

        $verification = PitchingVerification::firstOrNew([
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



}