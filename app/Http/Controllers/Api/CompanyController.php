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
use App\Http\Requests\Company\CompanyRequest;

class CompanyController extends Controller
{
    use ApiResponser;

    function __construct(){
    }

    function profile(){

        $company = Company::query()
        ->select('id','name','registration_date','email','phone','address','postcode','city','states','board_of_directors','paid_capital','experiences')
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

    public function update_profile(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->name = $request->name;
        $company->registration_date = $request->registration_date;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->postcode = $request->postcode;
        $company->city = $request->city;
        $company->states = $request->states;
        $company->board_of_directors = $request->board_of_directors;
        $company->paid_capital = $request->paid_capital;
        $company->experiences = $request->experiences;

        $company->save();
 
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }


    function mof(){

        $company = Company::query()
        ->select('id','mof_registration_number','is_mof_active','is_mof_cert_uploaded','mof_expiry_date')
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
    public function update_mof(CompanyRequest $request){

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

    function ssm(){

        $company = Company::query()
        ->select('id','ssm_registration_number','is_ssm_cert_uploaded','ssm_expiry_date')
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
    public function update_ssm(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->ssm_registration_number = $request->ssm_registration_number;
        $company->ssm_expiry_date = $request->ssm_expiry_date;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }

    // only accept PDF
    public function upload(CompanyRequest $request){
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

                DB::table('companies')
                ->where('id', $company->id)
                ->update([$request->field => true]);
            }
        }

        return response([
            $request->field => $uploaded ? 'true' : 'false',
        ]);
    }

}