<?php
namespace App\Services;

use App\Models\TenderSubmission;
use App\Models\Approval;
use Auth;
use Storage;

class JspdAdminService {


    // contstructor
    public function __construct(){
    }

    public function paginate($item = 50)
    {
        return TenderSubmission::query()
            ->has('user.approved_company')
            //->whereIn('tender_detail_id',[1,2])
            //->sortable()
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )

            // need to check company_approvals
            // ->orWhereHas('user.company', fn($query) =>
            //     $query->where('is_approved', true)
            //     )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('jspd-admins.index'));
    }

    public function approved($item = 50)
    {
        return TenderSubmission::query()

            ->has('approved','>=', 2)
            ->has('scorings','=', 3)
            ->has('verifications','=', 2)
            ->has('user.approved_company')
           // ->whereIn('tender_detail_id',[1,2])
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('jspd-admins.approved'));
    }

    public function failed($item = 50)
    {
        return TenderSubmission::query()

            ->has('failed','>=', 2)
            ->has('scorings','=', 3)
            ->has('verifications','=', 2)
            ->has('user.approved_company')
            //->whereIn('tender_detail_id',[1,2])
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('jspd-admins.failed'));
    }


    public function pending($item = 50)
    {
        return TenderSubmission::query()

            ->has('scorings','!=', 3)
            ->has('verifications','!=', 2)
            ->has('user.approved_company')
            //->whereIn('tender_detail_id',[1,2])
            ->whereHas('tender.tender_detail', fn($query) =>
                $query->whereIn('id', [1,2])
            )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('jspd-admins.pending'));
    }


    public function search($request)
    {
        $q = $request->input('query');
        $tenders = TenderSubmission::query()

                        // ->orWhereHas('tender.tender_detail', fn($query) =>
                        //     $query->whereIn('id', [1,2])
                        // )
                        ->orWhereHas('user.approved_company', fn($query) =>
                            $query->where('name', 'LIKE', '%' . $q . '%')
                            ->orWhere('email', 'LIKE', '%' . $q . '%')
                            ->orWhere('id', 'LIKE', '%' . $q . '%')
                            ->orWhere('phone', 'LIKE', '%' . $q . '%')

                        )
                        ->orWhereHas('tender', fn($query) =>
                            $query->where('programme_category', 'LIKE', '%' . $q . '%')
                            ->orWhere('type', 'LIKE', '%' . $q . '%')
                            ->orWhere('duration', 'LIKE', '%' . $q . '%')
                            ->orWhere('channel', 'LIKE', '%' . $q . '%')
                            ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                        )

                        ->paginate(50)
                        ->setPath(route('jspd-admins.search'));

                        $tenders->appends([
                            'query' => $q
                            ]);
        return $tenders;
    }

    public function store($request){
        $approval = Approval::firstOrNew([
            'user_id' =>  $request['user_id'] ,
            'tender_submission_id' => $request['tender_submission_id']
        ]);

        $approval->user_id = $request['user_id'];
        $approval->is_approved = $request['is_approved'];
        $approval->save();

        return $approval;
    }

    public function create($request){
        return TenderSubmission::create($request->except(['_token','_method']));
    }

    public function find($id){
        return TenderSubmission::find($id);
    }

    public function update($request, $id){
        return TenderSubmission::where('id',$id)->update($request->except(['_token','_method']));
    }

    public function destroy($id){
        $tenderSubmission = TenderSubmission::findOrFail($id);
        $tenderSubmission->scorings()->delete();
        $tenderSubmission->verifications()->delete();
        $tenderSubmission->signers()->delete();
        $tenderSubmission->scorings()->delete();
        $tenderSubmission->approval()->delete();


        // $video = User::has('video')->get();
        //dd($tenderSubmission->video());
        $this->video = new \App\Services\VideoService;
        $video = \App\Models\Video::query()->where('tender_submission_id', $id)->first();

        if($video){

            if( Storage::disk('assets')->exists($video->id) && Storage::disk('streaming')->exists($video->id)  ){
                $this->video->delete($video->id);
            }
            $video->delete();
        }


        if(Storage::disk('proposals')->exists($tenderSubmission->id)){
            Storage::disk('proposals')->deleteDirectory( $tenderSubmission->id ); // private dir
        }

       $tenderSubmission->delete();

       return $tenderSubmission;
    }

}
