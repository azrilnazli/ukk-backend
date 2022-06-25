<?php
namespace App\Services;

use App\Models\Tender;
use Auth;

class TenderService {

    // contstructor
    public function __construct(){

    }

    public function paginate($items = 50){
        return Tender::query()
                    ->with('tender_detail')
                    ->orderBy('id','desc')
                    ->paginate($items)
                    ->setPath(route('tenders.index'));
    }

    public function search($request)
    {
        // $query = $request->input('query');
        // return Tender::where([['title', 'like', "{$query}%"]])
        //                 ->paginate(10)->setPath('tenders');
        $q = $request->input('query');
        $tenders = Tender::query()
                    ->where('channel', 'LIKE', '%' . $q . '%')
                    ->orWhere('id', 'LIKE', '%' . $q . '%')
                    ->orWhere('type', 'LIKE', '%' . $q . '%')
                    ->orWhere('tender_category', 'LIKE', '%' . $q . '%')
                    ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                    ->orWhere('duration', 'LIKE', '%' . $q . '%')


                    ->paginate(50);

        $tenders->appends(['search' => $q]);

        return $tenders;

    }

    public function create($request){
        // return Tender::create([
        //         'user_id' => Auth::user()->id,
        //         'channel' => $request['channel'],
        //         'language' => $request['language'],
        //         'programme_code' => $request['programme_code'],
        //         'tender_category' => $request['tender_category'],
        //         'title' => $request['title'],
        //         'description' => $request['description'],
        //     ]);

        $tender = Tender::create($request->except(['_token','_method']));

        // ManyToMany with TenderLanguage
        $tender->languages()->sync($request->input('languages'));

        return $tender;
    }

    public function find($id){
        return Tender::find($id);
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

        $tender = Tender::where('id',$id)->update($request->except(['_token','_method']));

        // ManyToMany with TenderLanguage
        $tender->languages()->sync($request->input('languages'));

        return $tender;

    }

    public function destroy($id){
        return Tender::where('id',$id)->delete();
    }

}
