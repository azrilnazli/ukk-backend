<?php
namespace App\Services\Screening;

use Illuminate\Database\Eloquent\Builder;
use App\Models\ScreeningScoring;
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
            //->with('screening_owner')
            // has, where, whereHas , doesntHave , whereDoesntHave, whereNot
            ->whereHas('screening_signers', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-scorings.index'));
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
            //->with('screening_owner')
            // has, where, whereHas , doesntHave , whereDoesntHave, whereNot
            ->whereHas('screening_signers', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->whereDoesntHave('screening_scorings', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-scorings.pending_tasks'));
    }


    public function finished_tasks($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()
            //->with('screening_owner')
            // has, where, whereHas , doesntHave , whereDoesntHave, whereNot
            ->whereHas('screening_signers', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->whereHas('screening_scorings', function(Builder $query){
                $query->where('user_id', auth()->user()->id );
            })
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('screening-scorings.finished_tasks'));
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

                        ->paginate(50)
                        ->setPath(route('screening-scorings.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;

    }



    public function store($request, $tenderSubmission){

        $collection = collect($request)->except(['_token','_method']);

        $scoring = ScreeningScoring::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'tender_submission_id' => $tenderSubmission->id
        ]);

        $collection
        ->prepend(date('Y-m-d H:i'), 'created_at')
        ->prepend(auth()->user()->id, 'user_id')
        ->prepend($tenderSubmission->id, 'tender_submission_id');

        //$scoring->fill($collection->toArray())->save();
        $scoring->insertOrIgnore($collection->toArray());

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
