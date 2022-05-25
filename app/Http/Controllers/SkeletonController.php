<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index','show','search']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(){}
    public function search(Request $request){}
    public function create(){}
    public function store(Request $request){}
    public function show(Role $user){}
    public function edit(Role $user){}
    public function update(Request $request, User $user){}
    public function destroy(Role $role){}

}
