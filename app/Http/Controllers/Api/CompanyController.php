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

    function bumiputera(){

        $company = Company::query()
        ->select('id','is_bumiputera','bumiputera_registration_number','is_bumiputera_cert_uploaded','bumiputera_expiry_date')
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
    public function update_bumiputera(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->is_bumiputera = $request->is_bumiputera;
        $company->bumiputera_registration_number = $request->bumiputera_registration_number;
        $company->bumiputera_expiry_date = $request->bumiputera_expiry_date;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }

    function kkmm_syndicated(){

        $company = Company::query()
        ->select('id','kkmm_syndicated_registration_number','is_kkmm_syndicated_cert_uploaded','kkmm_syndicated_expiry_date')
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
    public function update_kkmm_syndicated(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->kkmm_syndicated_registration_number = $request->kkmm_syndicated_registration_number;
        $company->kkmm_syndicated_expiry_date = $request->kkmm_syndicated_expiry_date;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }    

    function kkmm_swasta(){

        $company = Company::query()
        ->select('id','kkmm_swasta_registration_number','is_kkmm_swasta_cert_uploaded','kkmm_swasta_expiry_date')
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
    public function update_kkmm_swasta(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->kkmm_swasta_registration_number = $request->kkmm_swasta_registration_number;
        $company->kkmm_swasta_expiry_date = $request->kkmm_swasta_expiry_date;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }    

    function finas_fp(){

        $company = Company::query()
        ->select('id','finas_fp_registration_number','is_finas_fp_cert_uploaded','finas_fp_expiry_date')
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
    public function update_finas_fp(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->finas_fp_registration_number = $request->finas_fp_registration_number;
        $company->finas_fp_expiry_date = $request->ssm_expiry_date;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }    

    function finas_fd(){

        $company = Company::query()
        ->select('id','finas_fd_registration_number','is_finas_fd_cert_uploaded','finas_fd_expiry_date')
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
    public function update_finas_fd(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->finas_fd_registration_number = $request->finas_fd_registration_number;
        $company->finas_fd_expiry_date = $request->ssm_expiry_date;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }      

    function audit(){

        $company = Company::query()
        ->select('id','current_audit_year','is_current_audit_year_cert_uploaded','paid_capital')
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
    public function update_audit(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->current_audit_year = $request->current_audit_year;
        $company->paid_capital = $request->paid_capital;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }      

    function bank(){

        $company = Company::query()
        ->select('id','bank_name','bank_branch','bank_statement_date_start','bank_statement_date_end','bank_account_number')
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
    public function update_bank(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->bank_name = $request->bank_name;
        $company->bank_branch = $request->bank_branch;
        $company->bank_account_number = $request->bank_account_number;

        $company->bank_statement_date_start = $request->bank_statement_date_start;
        $company->bank_statement_date_end = $request->bank_statement_date_end;
       

        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }   

    function board_of_directors(){

        $company = Company::query()
        ->select('id','board_of_directors')
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
    public function update_board_of_directors(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->board_of_directors = $request->board_of_directors;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }    
    

    function experiences(){

        $company = Company::query()
        ->select('id','experiences')
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
    public function update_experiences(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->experiences = $request->experiences;
        $company->save();
    
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }      


    function credit(){

        $company = Company::query()
        ->select('id','is_credit_cert_uploaded')
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
    public function update_credit(CompanyRequest $request){

        // company profile
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        $company->is_credit_cert_uploaded = true;
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
            'id' => $company->id,
        ]);
    }


    public function check_profile() {
        $company = Company::query()
            ->select('name','registration_date','email','phone','address','postcode','city','states','board_of_directors','paid_capital','experiences')
            ->where('user_id', auth()->user()->id)
            
            ->first();

        $completed = true;
        //Log::info('check profile');
        $profile = collect($company);
     
        $completed = $profile->filter(function($item, $key) use ($completed) {
            //Log::info($item);
            $completed = 'nazli';
            $forget = [ 'created_at','updated_at'];
            if(!in_array($item, $forget)){

                if(is_null($item)){
                    return false;
                }
                
            }
        });

        Log::info($completed);
        return response([
            'status' => $completed
        ]);
    }

}