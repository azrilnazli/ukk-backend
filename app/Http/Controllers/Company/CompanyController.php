<?php

namespace App\Http\Controllers\Company;

use Auth;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Http\Controllers\Controller;
use Route;
use Carbon\Carbon;

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

    static function routes()
    {
        Route::get('/companies/search', [CompanyController::class, 'search'])->name('companies.search');
        Route::get('/companies/requested', [CompanyController::class, 'requested'])->name('companies.requested');
        Route::resource('companies', CompanyController::class);
    }


    public function search(Request $request){
        //$q = $request['query'];
        $q = $request->input('query');

        $data = Company::query()
                    ->where('name', 'LIKE', '%' . $q . '%')
                    ->orWhere('id', 'LIKE', '%' . $q . '%')
                    ->orWhere('email', 'LIKE', '%' . $q . '%')
                    ->orWhere('phone', 'LIKE', '%' . $q . '%')
                    ->orWhere('address', 'LIKE', '%' . $q . '%')
                    ->orWhere('postcode', 'LIKE', '%' . $q . '%')
                    ->orWhere('city', 'LIKE', '%' . $q . '%')
                    ->orWhere('states', 'LIKE', '%' . $q . '%')
                    ->orWhere('board_of_directors', 'LIKE', '%' . $q . '%')
                    ->orWhere('experiences', 'LIKE', '%' . $q . '%')
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



    public function create()
    {
        return view('companies.create');
    }


    public function show(Company $company)
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

        // previous comments
        $comments = $this->company->get_comments($company->id);
        return view('companies.show',compact(['company','documents','comments']));
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
            'bumiputera',
            'authorization_letter',
            'official_company_letter'
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
