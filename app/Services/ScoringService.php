<?php
namespace App\Services;

use App\Models\Scoring;
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

    public function tasks($item = 50){
        return TenderSubmission::query()
        ->sortable()
        ->whereHas('signers', fn($query) =>
            $query->where('user_id', auth()->user()->id )
            )
        ->orderBy('id','desc')
        ->paginate($item)
        ->setPath(route('scorings.tasks'));
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

    // public function store($request){
    //     return Scoring::create($request->except(['_token','_method']));
    // }

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

        $scoring->menepati_keperluan_asas_status = $request['menepati_keperluan_asas_status'];
        $scoring->menepati_keperluan_asas_message = $request['menepati_keperluan_asas_message'];

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
