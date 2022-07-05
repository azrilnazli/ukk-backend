<?php
namespace App\Services;

use App\Models\TenderSubmission;
use Auth;

class TenderSubmissionService {


    // contstructor
    public function __construct(){

    }

    // public function paginate($items = 50){
    //     return TenderSubmission::orderBy('id','desc')->paginate($items)->setPath('tender_submissions');
    // }

    public function paginate($item = 50)
    {
        return TenderSubmission::query()
            ->sortable()
            ->whereHas('company.company_approvals', fn($query) =>
                $query->where('is_approved', true)
                )
            ->orderBy('id','desc')
            ->paginate($item)
            ->setPath(route('tender_submissions.index'));
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

    public function create($request){
        // return Tender::create([
        //         'user_id' => Auth::user()->id,
        //         'channel' => $request['channel'],
        //         'language' => $request['language'],
        //         'programme_code' => $request['programme_code'],
        //         'programme_category' => $request['programme_category'],
        //         'title' => $request['title'],
        //         'description' => $request['description'],
        //     ]);

        return TenderSubmission::create($request->except(['_token','_method']));
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

    public function fields($tenderSubmission){
        $unwanted = ['id','is_video','user_id','video_id','tender_id','company_id','tender_detail_id','created_at','updated_at','is_scoring_completed','is_verification_completed','is_pdf_cert_uploaded','added_by'];
        $columns = $tenderSubmission->getTableColumns();
        return $fields = array_diff($columns,$unwanted);
    }

}
