<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;


class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-list', ['only' => ['index','show','search']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::all();
        return View('users.permissions.index', compact('permissions'));
    }

    public function delete(Role $role){
 
        if($role->delete()){
            return redirect('roles')->with('success','Role ' . $role->name . ' successfully deleted.'); // redirect on success
        }
    }

}
