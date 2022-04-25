<?php
namespace App\Http\Controllers\Api;

use DB;
use Auth;
use App\Models\Company;
use App\Traits\ApiResponser;

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
        //$company = Company::find(1);
        $company = Company::firstOrNew(['user_id' => auth()->user()->id ]);
        //$company->fill($request->all());
        
        $company->mof_registration_number = $request->mof_registration_number;
        $company->mof_expiry_date = $request->mof_expiry_date;
        $company->is_mof_active = $request->is_mof_active;
        $company->save();

        // check directory based on $company->id, if null, create 

        
        // JSON response
        return response([
            'message' => $request->all(),
        ]);
    }

    // only accept PDF
    public function upload(Request $request){
        // create directory in public storage using company_id
    }

}