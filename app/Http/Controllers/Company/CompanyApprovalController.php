<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyApproval;
use App\Services\CompanyApprovalService;
use App\Http\Requests\Company\CompanyApproval\StoreRequest;
use App\Http\Requests\Company\CompanyApproval\UpdateRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class CompanyApprovalController extends Controller
{
    var $service;
    var $company;

    function __construct(){
        $this->middleware('permission:company-approval-list|company-approval-create|company-approval-edit|company-approval-delete', ['only' => ['index','show']]);
        $this->middleware('permission:company-approval-create', ['only' => ['create','store']]);
        $this->middleware('permission:company-approval-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:company-approval-delete', ['only' => ['destroy']]);

        $this->service = new CompanyApprovalService;
        $this->company = new \App\Services\CompanyService;
    }

    static function routes() {

        Route::get('/company-approvals', [CompanyApprovalController::class, 'index'])->name('company-approvals.index');
        Route::get('/company-approvals/search', [CompanyApprovalController::class, 'search'])->name('company-approvals.search');
        Route::get('/company-approvals/{companyApproval}/edit', [CompanyApprovalController::class,'edit'])->name('company-approvals.edit');
        Route::put('/company-approvals/{companyApproval}/edit', [CompanyApprovalController::class,'update'])->name('company-approvals.update');
        Route::delete('/company-approvals/{companyApproval}', [CompanyApprovalController::class, 'destroy'])->name('company-approvals.destroy');
    }


    public function index()
    {
        $companyApprovals =$this->service->paginate();
        return view('company_approvals.index')->with(compact('companyApprovals'));
    }

    public function search(Request $request){

        $companyApprovals =$this->service->search($request);
        return view('company_approvals.index')->with(compact('companyApprovals'));
    }



    public function edit(CompanyApproval $companyApproval)
    {
        $documents = [
            'ssm',
            'mof',
            'finas_fp',
            'finas_fd',
            'kkmm_swasta',
            'kkmm_syndicated',
            'bank',
            'audit',
            'credit',
            'bumiputera',
            'authorization_letter',
            'official_company_letter'
        ];

        // Company data
        $company = $companyApproval->company;

        // Comment
        $comments = $this->service->get_comments($companyApproval->id);

        // render View
        return view('company_approvals.edit',compact('company','documents','comments','companyApproval'));
    }

    public function update(UpdateRequest $request, CompanyApproval $companyApproval)
    {
        $this->service->update($request, $companyApproval->id);

        $this->service->add_comment(
                            $request,
                            $companyApproval->company->id,
                            $companyApproval->id,
                            $companyApproval->tender_detail->id
                        ); // comment

        return redirect()->route('company-approvals.index')->with('success','Company Approval updated successfully.');
    }



    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back()->with('success','Company Approval deleted successfully.');
    }
}
