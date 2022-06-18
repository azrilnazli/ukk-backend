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


class UserRoleController extends Controller
{
    function __construct()
    {

        $this->middleware('permission:role-list', ['only' => ['index','show','search']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return View('users.roles.index', compact('roles'));
    }

    public function search(Request $request){}

    public function create(){
        return View('users.roles.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|alpha_dash|unique:roles|max:255',
        ]);

        $role = Role::create($validated); // create Role

        return redirect('roles')->with('success','Role ' . $role->name . ' successfully created.'); // redirect on success

    }

    public function show(Role $user){}

    public function edit($role){

        $role = Role::where('name',$role)
                ->with('permissions')
                ->first();

        $actions = ['list','create','edit','delete'];
        $controllers = collect(Config::get('controller'))
                        ->flip()
                        ->map( function( $val, $key ) use ($actions) {

                            foreach($actions as $action){
                                $new[] = "$key-$action";
                            }

                            return $new;

                        });

        $permissions = collect($role->permissions)
                        ->map( function( $val,$key ){
                            $temp = explode("-",$val->name);
                            $val['controller'] = $temp[0];
                            //$actions[] = $temp[1];
                            return $val['controller'];
                        })->unique();


        return View('users.roles.edit')
                ->with('role', $role)
                ->with('permissions', $permissions)
                ->with('controllers', $controllers);
    }

    public function update(Request $request, $role){

        $role = Role::findByName($role); // find the role collection

        // list of registered controllers
        $actions = ['list','create','edit','delete'];
        $controllers = collect(Config::get('controller'))
                        ->flip()
                        ->map( function( $val, $key ) use ($actions) {

                            foreach($actions as $action){
                                $controller[] = "$key-$action";
                            }
                            return $controller;
                        });

        // revoke current permission owned by role
        $controllers->each(function ($controller, $key) use ($role){
            $role->revokePermissionTo($controller);
        });

        // turn Array to Collection
        collect($request->input('controllers'))
        ->each( function($controller, $key) use ($role){

            if(Permission::where('name',$controller)->count() > 0 ){ // need to do some Permission checking
                $role->givePermissionTo($controller); // assign existing permission to role
            } else {
                Permission::create(['name' => $controller]); // create permission of not exists
                $role->givePermissionTo($controller); // assign existing permission to role

            }
        });
        //$role->syncPermissions($request->get('controllers'));
        return redirect('roles')->with('success','Role ' . $role->name . ' successfully updated.'); // redirect on success
    }
    public function delete(Role $role){

        if($role->delete()){
            return redirect('roles')->with('success','Role ' . $role->name . ' successfully deleted.'); // redirect on success
        }
    }

}
