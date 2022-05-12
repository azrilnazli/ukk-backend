<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;

class CompanyController extends Controller
{
    var $company;

    function __construct()
    {
         $this->middleware('permission:company-list|company-create|company-edit|company-delete', ['only' => ['requested','index','show']]);
         $this->middleware('permission:company-create', ['only' => ['create','store']]);
         $this->middleware('permission:company-edit',   ['only' => ['edit','update']]);
         $this->middleware('permission:company-delete', ['only' => ['destroy']]);

         $this->company = new CompanyService;
    }


    public function search(Request $request){
        //$q = $request['query'];
        $q = $request->input('query');
        
        $data = Company::query()
                    ->where('name', 'LIKE', '%' . $q . '%')
                    ->orWhere('email', 'LIKE', '%' . $q . '%')
                    ->paginate(50);

        $data->appends(['search' => $q]);

        return view('companies.index')->with(compact('data'));
    }

    public function index()
    {
        $data = $this->company->paginate();
        //$data = $this->company->requested();
        return view('companies.index')->with(compact('data'));
    }

    public function is_new()
    {
        $companies = Company::query()
                        ->sortable()
                        ->orderBy('created_at','desc')
                        ->where('is_completed', false )
                        ->where('is_approved', false )
                        ->where('is_rejected', false )
                        ->get();
        return view('companies.all')->withCompanies($companies);
    }

    public function is_resubmit()
    {
        $companies = Company::query()
                        ->sortable()
                        ->orderBy('updated_at','desc')
                        ->where('is_completed', true)
                        ->where('is_rejected', true)
                        ->get();
        return view('companies.all')->withCompanies($companies);
    }

    public function is_pending()
    {
        $companies = Company::query()
                        ->sortable()
                        ->orderBy('updated_at','desc')
                        ->where('is_completed', true )
                        ->where('is_approved', false )
                        ->where('is_rejected', false )
                        ->get();
        return view('companies.all')->withCompanies($companies);
    }

    public function is_approved()
    {
        $companies = Company::query()
                        ->sortable()
                        ->orderBy('updated_at','desc')
                        ->where('is_approved', true)
                        ->get();
        return view('companies.all')->withCompanies($companies);
    }

    public function is_rejected()
    {
        $companies = Company::query()
                        ->sortable()
                        ->orderBy('updated_at','desc')
                        ->where('is_completed', false )
                        ->where('is_rejected', true)
                        ->get();
        return view('companies.all')->withCompanies($companies);
    }
    
    public function requested()
    {
        $data = $this->company->requested();
        return view('companies.index')->with(compact('data'));
    }


    public function create()
    {
        return view('companies.create');
    }

    public function show()
    {
        return view('companies.create');
    }

    public function store(StoreRequest $request)
    {
        $this->company->create($request);
        return redirect('companies')->with('success','Company created successfully');
    }


    public function edit(Company $company)
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
            'bumiputera'

        ];

        // previous comments
        $messages = $this->company->get_messages($company->id);
        return view('companies.edit',compact(['company','documents','messages']));
    }

    public function update(UpdateRequest $request, $id)
    {

        //dd($request);
        $this->company->update($request, $id); // approval ( approve or reject)
        $this->company->add_comment($request, $id); // comment
        return redirect()->route('companies.index', $id)->with('success','Company updated.');
    }

    public function destroy($id)
    {
        $this->company->destroy($id);
        return redirect()->back()->with('success','Company deleted.');
    }
}