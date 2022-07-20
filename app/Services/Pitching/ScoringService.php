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
            ->setPath(route('pitching-scorings.index'));
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
            ->setPath(route('pitching-scorings.pending_tasks'));
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
            ->setPath(route('pitching-scorings.finished_tasks'));
    }

    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

                        // ->has('approved','>=', 2)
                        // ->has('scorings','=', 3)
                        // ->has('verifications','=', 2)
                        // ->whereHas('pitching_signers', fn($query) =>
                        // $query->where('user_id', auth()->user()->id )
                        // )
                        // ->whereHas('user.company.company_approvals', fn($query) =>
                        //     $query->where('is_approved', true)
                        // )
                        // // ->whereIn('tender_detail_id',[1,2])
                        // ->whereHas('tender.tender_detail', fn($query) =>
                        //     $query->whereIn('id', [1,2])
                        // )

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
                        ->setPath(route('pitching-scorings.search'));

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
