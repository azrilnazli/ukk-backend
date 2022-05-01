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

    public function index()
    {
        $data = $this->company->paginate();
        return view('companies.index')->with(compact('data'));
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
        return view('companies.edit',compact(['company','documents']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $this->company->update($request, $id);
        return redirect()->route('companies.index', $id)->with('success','Company updated.');
    }

    public function destroy($id)
    {
        $this->company->destroy($id);
        return redirect()->back()->with('success','Company deleted.');
    }
}