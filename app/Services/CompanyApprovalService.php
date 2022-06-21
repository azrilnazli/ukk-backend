<?php
namespace App\Services;

use App\Models\TenderSubmission;
use App\Models\CompanyApproval;
use App\Models\Company;
use Auth;
use Storage;
use Log;

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


    public function check_ssm(){
        $fields = ['ssm_registration_number','is_ssm_cert_uploaded','ssm_expiry_date'];
        return $this->check($fields);

    }

    public function check_mof(){
        $fields = ['mof_registration_number','is_mof_cert_uploaded','mof_expiry_date'];
        return $this->check($fields);
    }

    public function check_kkmm_syndicated(){
        $fields = ['kkmm_syndicated_registration_number','is_kkmm_syndicated_cert_uploaded','kkmm_syndicated_expiry_date'];
        return $this->check($fields);
    }

    public function check_kkmm_swasta(){
        $fields = ['kkmm_swasta_registration_number','is_kkmm_swasta_cert_uploaded','kkmm_swasta_expiry_date'];
        return $this->check($fields);
    }

    public function check_finas_fp(){
        $fields = ['finas_fp_registration_number','is_finas_fp_cert_uploaded','finas_fp_expiry_date'];
        return $this->check($fields);
    }

    public function check_finas_fd(){
        $fields = ['finas_fd_registration_number','is_finas_fd_cert_uploaded','finas_fd_expiry_date'];
        return $this->check($fields);
    }

    public function check_credit(){
        $fields = ['is_credit_cert_uploaded'];
        return $this->check($fields);
    }

    public function check_authorization_letter(){
        $fields = ['is_authorization_letter_cert_uploaded'];
        return $this->check($fields);
    }

    public function check_official_company_letter(){
        $fields = ['is_official_company_letter_cert_uploaded'];
        return $this->check($fields);
    }

    public function check_audit(){
        $fields = ['current_audit_year','is_current_audit_year_cert_uploaded','paid_capital'];
        return $this->check($fields);
    }

    public function check_bank(){
        $fields = ['bank_name','bank_branch','bank_statement_date_start','bank_statement_date_end','bank_account_number'];
        return $this->check($fields);
    }

    public function check_bumiputera(){
        $fields = ['is_bumiputera'];
        //$fields = ['is_bumiputera','bumiputera_registration_number','is_bumiputera_cert_uploaded','bumiputera_expiry_date'];
        return $this->check($fields);
    }

    public function check_experiences(){
        $fields = ['experiences'];
        return $this->check($fields);
    }

    public function check_board_of_directors(){
        $fields = ['board_of_directors'];
        return $this->check($fields);
    }

    public function check_profile(){
        $fields = ['name','email','phone','address','postcode','city','states'];
        return $this->check($fields);
    }

    public function check($fields) {
        //$fields = implode(',', $fields);
        $company = \App\Models\Company::query()
            ->select($fields) // select single or multiple fields
            ->where('user_id', auth()->user()->id)
            ->first();

        // turn into collection
        $profile = collect($company);

        // if $profile is empty ?
        if( collect($profile)->isEmpty() == TRUE ){
            return false;
        }

        $is_empty = null;
        $is_empty = $profile->filter(function($item, $key)  {
           // Log::info($item . '->' . $key);
            $forget = [ 'created_at','updated_at']; // no need these fields
            if(!in_array($key, $forget)){
                //Log::info("check" . $item);
                if(is_null($item) || $item == '' || empty($item)){ // check the field
                    //Log::info("is-null " . $key);
                    return true; // return true to return current item to $is_empty
                }
            }
            return false;
        });
        return collect($is_empty)->isEmpty();
    }





}
