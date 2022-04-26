<?php
namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Log;
use App\Models\Company;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Form Validation
//use App\Http\Requests\Company\RegisterRequest;

class CompanyController extends Controller
{
    use ApiResponser;

    function __construct(){
    }

    function show_profile(){

        $company = Company::query()
        ->where('user_id', auth()->user()->id)
        ->first();

        $company ?

            $message = $this->success($company)
        : 
            $message =  response([
            'message' => 'no data',
        ]);
                
        return $message;

    }

    // custom field validation
    public function update_profile(Request $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->mof_registration_number = $request->mof_registration_number;
        $company->mof_expiry_date = $request->mof_expiry_date;
        $company->is_mof_active = $request->is_mof_active;
        $company->save();
 
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }

    // only accept PDF
    public function upload(Request $request){
        // log to laravel.log
        //Log::info($request);
        $uploaded = false;
        // get folder ID ( User hasOne Company)
        $company = DB::table('companies')

        // select required fields
        ->select(       
            DB::raw('companies.id'),
        )
        // belongs to who ?
        ->where('user_id', auth()->user()->id) // user_id
        // get the Collection
        ->first();

        //Log::info($company->id);
        if($request->hasFile('selectedFile')){ // if exists
         
            // move to folder
            $request->file('selectedFile')
            ->storeAs(
                $company->id, // path within disk's root
                $request->document, // filename
                'companies' // disk
            );

            Log::info($company->id);
            if(Storage::disk('companies')->exists($company->id) .'/'. $request->document){
                Log::info('file exists');
                $uploaded = true;

                // update to DB    
                $db = Company::find($company->id);
                $db->is_mof_cert_uploaded = TRUE;
                $db->save();
            }
        }

        return response([
            'is_mof_cert_uploaded' => $uploaded ? 'true' : 'false',
        ]);
    }

}