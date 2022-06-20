<?php
namespace App\Services;

use App\Models\TenderSubmission;
use App\Models\CompanyApproval;
use App\Models\Company;
use Auth;
use Storage;

class CompanyApprovalService {

    public function __construct(){}

    public function check_field($field) {

        $company = Company::query()
                    ->where('user_id', auth()->user()->id )
                    ->get($field);

        if(is_null($company->first()->$field)){
            return false;
        } else {
            return true;
        }
    }





}
