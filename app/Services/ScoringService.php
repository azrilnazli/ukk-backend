<?php
namespace App\Services;

use App\Models\Scoring;
use App\Models\Verification;
use App\Models\TenderSubmission;
use Auth;

class ScoringService {


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

    public function tasks($type,$item = 50){
        return TenderSubmission::query()
        ->sortable()
        // who is the owner of this TenderSubmission ?
        ->whereHas(
            $type, // Relation type ( signers , urusetias, owner)
            function($query)
            {
                $query->where('user_id', auth()->user()->id );
            }
        )
        // ->whereHas($type, fn($query) =>
        //     $query->where('user_id', auth()->user()->id )
        //     )
        ->orderBy('id','desc')
        ->paginate($item)
        ->setPath(route('scorings.tasks'));
    }

    public function pending_tasks($relation_type,$score_type,$item = 50){
        return TenderSubmission::query()
        ->sortable()
        // who is the owner of this TenderSubmission ?
        ->whereHas(
            $relation_type, // Relation type ( signers , urusetias, owner)
            function($query)
            {
                $query->where('user_id', auth()->user()->id );
            }
        )
        ->doesntHave($score_type) // yet to be signed
        ->orderBy('id','desc')
        ->paginate($item)
        ->setPath(route('scorings.pending_tasks'));
    }

    public function finished_tasks($relation_type,$score_type,$item = 50){
        return TenderSubmission::query()
        ->sortable()
        // who is the owner of this TenderSubmission ?
        ->whereHas(
            $relation_type, // Relation type ( signers , urusetias, owner)
            function($query)
            {
                $query->where('user_id', auth()->user()->id );
            }
        )
        ->has($score_type) // yet to be signed
        ->orderBy('id','desc')
        ->paginate($item)
        ->setPath(route('scorings.finished_tasks'));
    }

    public function search($type,$request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

                        ->orWhereHas($type, fn($query) =>
                            $query->where('user_id', auth()->user()->id )
                        )
                        ->orWhereHas('user.approved_company', fn($query) =>
                            $query->where('name', 'LIKE', '%' . $q . '%')
                            ->orWhere('email', 'LIKE', '%' . $q . '%')
                            ->orWhere('id', 'LIKE', '%' . $q . '%')
                            ->orWhere('phone', 'LIKE', '%' . $q . '%')

                        )
                        ->orWhereHas('score.tender', fn($query) =>
                            $query->where('programme_code', 'LIKE', '%' . $q . '%')
                            // ->orWhere('type', 'LIKE', '%' . $q . '%')
                            // ->orWhere('duration', 'LIKE', '%' . $q . '%')
                            // ->orWhere('channel', 'LIKE', '%' . $q . '%')
                            // ->orWhere('programme_category', 'LIKE', '%' . $q . '%')
                        )

                        ->paginate(50)
                        ->setPath(route('scorings.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }

    // public function store($request){
    //     return Scoring::create($request->except(['_token','_method']));
    // }

    public function store_verification($request){
        $verification = Verification::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'tender_submission_id' => $request['tender_submission_id']
        ]);

        $verification->user_id = $request['user_id'];
        $verification->is_verified = $request['is_verified'];
        $verification->save();

        return $verification;

    }

    public function store($request){

        $scoring = Scoring::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'tender_submission_id' => $request['tender_submission_id']
        ]);


        $scoring->user_id = $request['user_id'];
        $scoring->tender_submission_id = $request['tender_submission_id'];
        $scoring->tender_id = $request['tender_id'];
        $scoring->company_id = $request['company_id'];

        $scoring->assessment = $request['assessment'];
        $scoring->need_statement_comply = $request['need_statement_comply'];

        $scoring->tajuk_status = $request['tajuk_status'];
        $scoring->tajuk_message = $request['tajuk_message'];

        $scoring->sinopsis_status = $request['sinopsis_status'];
        $scoring->sinopsis_message = $request['sinopsis_message'];

        $scoring->idea_dan_subjek_status = $request['idea_dan_subjek_status'];
        $scoring->idea_dan_subjek_message = $request['idea_dan_subjek_message'];

        $scoring->lengkap_status = $request['lengkap_status'];
        $scoring->lengkap_message = $request['lengkap_message'];

        // $scoring->menepati_keperluan_asas_status = $request['menepati_keperluan_asas_status'];
        // $scoring->menepati_keperluan_asas_message = $request['menepati_keperluan_asas_message'];

        $scoring->syor_status = $request['syor_status'];

        if( $request['syor_status'] == 1 ){
            $scoring->syor_message_true = $request['syor_message_true'];
            $scoring->syor_message_false = null;
        } else {
            $scoring->syor_message_true = null;
            $scoring->syor_message_false = $request['syor_message_false'];
        }

        $scoring->pengesahan_comply = $request['pengesahan_comply'];


        $scoring->save($request->except(['_token','_method']));

        return $scoring;
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
