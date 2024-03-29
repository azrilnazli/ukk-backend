<?php
namespace App\Services\Screening;

use App\Models\ScreeningApproval;
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
                $query->whereIn('id', [3,4])
            )
            ->count();
    }

    // Approved Proposal
    public function approvedProposals()
    {
        // 1044 taken from JspdAdmin
        return TenderSubmission::query()
            ->has('screening_owner')
            ->has('screening_scorings','=', 3)
            ->has('screening_verification','=', 1)
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
        ->has('screening_owner')
        ->has('screening_scorings','=', 3)
        ->has('screening_verification','=', 1)
        ->get()
        ->map( function($value, $key){
            $total = null;
            foreach($value->screening_scorings as $score){
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
                if($result >= $min && $result <= $max){
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
            // that doesn't have any ScreeningOwner
            ->has('screening_owner')
            ->has('screening_scorings','=', 3)
            ->has('screening_verification','=', 1)
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-admins.dashboard'));
    }

    public function pendingTasks($item = 50)
    {
            return TenderSubmission::query()
            ->sortable()
            ->has('screening_signers','=', 3) // must have 3 signer
            ->has('screening_urusetias','=', 1) // must have 1 urusetia
            ->doesntHave('screening_approval') // not yet approved by ketua
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-admins.pending-tasks'));
    }

    public function finishedTasks($item = 50)
    {

            return TenderSubmission::query()
            ->sortable()
            ->has('screening_signers','=', 3) // must have 3 signer
            ->has('screening_urusetias','=', 1) // must have 1 urusetia
            ->has('screening_approval') // approved by ketua
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-admins.finished-tasks'));
    }


    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

                        ->where(function ($query) use ($q)  {

                            $query->whereHas('tender.tender_detail', function ($query) {
                                $query->whereIn('id', [3,4]);
                            })

                            ->whereHas('user.company', function ($query) use ($q) {
                                $query->where('name', 'LIKE', '%' . $q . '%');
                            });

                        })
                        ->has('screening_owner')
                        ->has('screening_scorings','=', 3)
                        ->has('screening_verification','=', 1)
                        ->paginate(50)
                        ->setPath(route('screening-verifications.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    public function store($request,$tenderSubmission){

        $approval = ScreeningApproval::firstOrNew([
            'user_id' =>  auth()->user()->id ,
            'tender_submission_id' => $tenderSubmission->id
        ]);

        $approval->user_id = auth()->user()->id ;
        $approval->tender_submission_id = $tenderSubmission->id;
        $approval->is_approved =  $request['is_approved'];
        $approval->save();

        return $approval;
    }

    public function find($id){
        return TenderSubmission::find($id);
    }



}
