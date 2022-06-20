<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Models\CompanyApproval;
use App\Models\TenderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Log;

class CompanyApprovalController extends Controller
{

    function __construct(){
        $this->service = new \App\Services\CompanyApprovalService;
    }

    static function routes()
    {
        Route::get('/company-approvals', [CompanyApprovalController::class, 'index'])->name('company-approvals.index');
        Route::get('/company-approvals/search', [CompanyApprovalController::class, 'search'])->name('company-approvals.search');
        Route::get('/company-approvals/create', [CompanyApprovalController::class,'create'])->name('company-approvals.create');
        Route::get('/company-approvals/check-for-approval/{module}', [CompanyApprovalController::class,'check_for_approval'])->name('company-approvals.check-for-approval');
        Route::get('/company-approvals/get-approval-status/{tenderDetail}', [CompanyApprovalController::class,'get_approval_status'])->name('company-approvals.get-approval-status');
        Route::post('/company-approvals/store', [CompanyApprovalController::class,'store'])->name('company-approvals.store');
        Route::post('/company-approvals/request-for-approval', [CompanyApprovalController::class,'request_for_approval'])->name('company-approvals.request-for-approval');
        Route::get('/company-approvals/{tenderDetail}/edit', [CompanyApprovalController::class,'edit'])->name('company-approvals.edit');
        Route::put('/company-approvals/{tenderDetail}/edit', [CompanyApprovalController::class,'update'])->name('company-approvals.update');
        Route::delete('/company-approvals/{tenderDetail}', [CompanyApprovalController::class, 'destroy'])->name('company-approvals.destroy');
    }

    // vendor wants to check his status
    public function get_approval_status(TenderDetail $tenderDetail)
    {

        // get current status from CompanyApproval

        // JSON response 200
        return response([
            'status' =>  'pending',
        ],200);
    }

    // Check vendor submitted documents
    public function check_for_approval($module)
    {
        return $this->$module();
    }

    // Vendor click button
    // sent data tender_detail_id
    // first time request status=pending
    public function request_for_approval(Request $request)
    {
        // should check if CompanyData meets TenderDetail->Requirement ?

        $company = \App\Models\Company::where('user_id', auth()->user()->id)->first();

        if(empty($company)){
            // JSON response 422
            return response([
                'message' => 'company does not exist',
            ],422);
        }

        // companyApproval
        $companyApproval = CompanyApproval::firstOrNew([
            'tender_detail_id' => $request->input('tender_detail_id'),
            'company_id' => $company->id
        ]);

        $companyApproval->status = 'pending';
        $companyApproval->save();

        // JSON response 200
        return response([
            'message' =>  $company ? 'success' : 'empty',
        ],200);
    }


    public function check_ssm(){
        $fields = ['ssm_registration_number','is_ssm_cert_uploaded','ssm_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_mof(){
        $fields = ['mof_registration_number','is_mof_cert_uploaded','mof_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_kkmm_syndicated(){
        $fields = ['kkmm_syndicated_registration_number','is_kkmm_syndicated_cert_uploaded','kkmm_syndicated_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_kkmm_swasta(){
        $fields = ['kkmm_swasta_registration_number','is_kkmm_swasta_cert_uploaded','kkmm_swasta_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_finas_fp(){
        $fields = ['finas_fp_registration_number','is_finas_fp_cert_uploaded','finas_fp_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_finas_fd(){
        $fields = ['finas_fd_registration_number','is_finas_fd_cert_uploaded','finas_fd_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_credit(){
        $fields = ['is_credit_cert_uploaded'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_authorization_letter(){
        $fields = ['is_authorization_letter_cert_uploaded'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_official_company_letter(){
        $fields = ['is_official_company_letter_cert_uploaded'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_audit(){
        $fields = ['current_audit_year','is_current_audit_year_cert_uploaded','paid_capital'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_bank(){
        $fields = ['bank_name','bank_branch','bank_statement_date_start','bank_statement_date_end','bank_account_number'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_bumiputera(){
        $fields = ['is_bumiputera','bumiputera_registration_number','is_bumiputera_cert_uploaded','bumiputera_expiry_date'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_experiences(){
        $fields = ['experiences'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_board_of_directors(){
        $fields = ['board_of_directors'];
        $status = $this->check($fields);
        return response([
            'status' => $status
        ]);
    }

    public function check_profile(){
        $fields = ['name','email','phone','address','postcode','city','states'];
        $status = $this->check($fields);
        Log::info('check profile ' . $status);
        return response([
            'status' => $status
        ]);
    }

    public function check($fields) {
        //$fields = implode(',', $fields);
        $company = \App\Models\Company::query()
            //->select('name','email','phone','address','postcode','city','states','board_of_directors','paid_capital','experiences')
            ->select($fields)
            ->where('user_id', auth()->user()->id)

            ->first();

        //$completed = true;

        $profile = collect($company);

        if(collect($profile)->isEmpty() == TRUE){
            return false;
        }


        //Log::info("is-null " . $profile);
        $is_empty = null;
        $is_empty = $profile->filter(function($item, $key)  {
           // Log::info($item . '->' . $key);
            $forget = [ 'created_at','updated_at'];
            if(!in_array($key, $forget)){
                //Log::info("check" . $item);
                if(is_null($item) || $item == '' || empty($item)){
                    //Log::info("is-null " . $key);
                    return true;
                }
            }
            return false;

        });

        return collect($is_empty)->isEmpty();


    }


}
