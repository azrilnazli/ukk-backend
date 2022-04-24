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
        ->where('id', 1)
        ->first();

        $company ?

            $message = $this->success($company)
        : 
            $message = $this->error([
                'message' => 'error'
            ]);
                
        return $message;

    }

    function update_profile(Request $request){

        return $this->success([
            'company' => $request->all()
        ]);

    }

}