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
        Route::get('/company-approvals/allow-request/{tenderDetail}', [CompanyApprovalController::class,'allow_request'])->name('company-approvals.allow-request');
        Route::get('/company-approvals/check-for-approval/{module}', [CompanyApprovalController::class,'check_for_approval'])->name('company-approvals.check-for-approval');
        Route::get('/company-approvals/get-approval-status/{tenderDetail}', [CompanyApprovalController::class,'get_approval_status'])->name('company-approvals.get-approval-status');
        Route::post('/company-approvals/request-for-approval', [CompanyApprovalController::class,'request_for_approval'])->name('company-approvals.request-for-approval');
    }

    // vendor wants to check his status
    // status = null,pending,approved,rejected
    public function get_approval_status(TenderDetail $tenderDetail)
    {
        // get Company data based on loggedIn User
        $company = \App\Models\Company::where('user_id', auth()->user()->id )->first();
        if(is_null($company)){
            // return response as JSON
            return response([
                'status' => 'No Company Data' // return as boolean
            ]);
        }

        $result = \App\Models\CompanyApproval::query()
                    ->where('company_id',$company->id)
                    ->where('tender_detail_id',$tenderDetail->id)
                    ->first();

        // JSON response 200
        return response([
            'status' =>  !is_null($result) ? ucFirst($result->status) : 'Not Submitted' ,
        ],200);
    }

    // Check vendor submitted documents
    public function check_for_approval($module)
    {
        return response([
            'status' => $this->service->$module()
        ]);
    }

    // to check user if user Company data meets TenderRequirement ?
    public function allow_request(TenderDetail $tenderDetail)
    {

        // set $allow to true
        $status = true;

        // get Company data based on loggedIn User
        $company = \App\Models\Company::where('user_id', auth()->user()->id )->first();

        // if Company is null ?
        if(is_null($company)){
            // return response as JSON
            return response([
                'status' => false // return as boolean
            ]);
        }

        // load tender requirements based on submitted $id
        $requirements = $tenderDetail->tender_requirements;

        // run the loop
        foreach($requirements as $requirement){
            // run the check
            // CompanyData vs TenderRequirement
            $module = $requirement->module;
            $status =  $this->service->$module(); // return boolean
            if($status == false){
                break;
            }
        }

        //Log::info('company id ' . $company->id);
        //Log::info('tender detail id ' . $tenderDetail->id);

        // check CompanyApproval status
        // only allow when null or rejected
        // disable if pending or approved
        // if ($result->first()) { }
        // if (!$result->isEmpty()) { }
        // if ($result->count()) { }
        // if (count($result)) { }

        // check against company_id and tender_id
        $result = \App\Models\CompanyApproval::query()
                            ->where('company_id',$company->id)
                            ->where('tender_detail_id',$tenderDetail->id)
                            ->first();
        if(!is_null($result)){
            //Log::info('status ' . $result->status);
            if($result->status == 'pending' OR $result->status == 'rejected'){
                $status = false;
            }
        }

        // return final $status
        return response([
            'status' => $status // return as boolean
        ]);
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
}
