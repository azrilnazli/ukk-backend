<?php
namespace App\Services\Pitching;

use Illuminate\Database\Eloquent\Builder;
use App\Models\PitchingScoring;
use App\Models\Verification;
use App\Models\TenderSubmission;
use Auth;

class ScoringService {


    // contstructor
    public function __construct(){

    }


    // list proposal that assigned to logged user
    public function paginate($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()
            //->with('pitching_owner')
            // has, where, whereHas , doesntHave , whereDoesntHave, whereNot
            ->whereHas('pitching_signers', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
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

    public function pending_tasks($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()
            //->with('pitching_owner')
            // has, where, whereHas , doesntHave , whereDoesntHave, whereNot
            ->whereHas('pitching_signers', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->whereDoesntHave('pitching_scorings', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('tender_submissions.index'));
    }


    public function finished_tasks($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()
            //->with('pitching_owner')
            // has, where, whereHas , doesntHave , whereDoesntHave, whereNot
            ->whereHas('pitching_signers', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->whereHas('pitching_scorings', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('tender_submissions.index'));
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
    //     return PitchingScoring::create($request->except(['_token','_method']));
    // }



    public function store($request, $tenderSubmission){

        $collection = collect($request)->except(['_token','_method']);

        $scoring = PitchingScoring::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'tender_submission_id' => $tenderSubmission->id
        ]);

        $collection
        ->prepend(auth()->user()->id, 'user_id')
        ->prepend($tenderSubmission->id, 'tender_submission_id');

        //$scoring->fill($collection->toArray())->save();
        $scoring->fill($collection->toArray())->insertOrIgnore();

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
