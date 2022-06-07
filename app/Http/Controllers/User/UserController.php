<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;


class UserController extends Controller
{
    var $user;

    function __construct()
    {

        //$this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        
        $this->middleware('permission:user-list', ['only' => ['index','show','search']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

        $this->user = new UserService;
    }

    public function index()
    {
        $data = $this->user->paginate(50);
        return view('users.index',compact(['data']));
    }

    public function search(Request $request){

        $data = $this->user->search($request);

        return view('users.index')->with(compact('data'));
    }

 
    public function create()
    {
        $roles = $this->user->getRoles();
        return view('users.create', compact('roles'));
    }

 
    public function store(StoreUserRequest $request)
    {
        $this->user->store($request);
        return redirect('users')->with('success','User ' . $request['name'] . ' added.');
    }

    public function show(User $user)
    {

        return view('users.show',compact(['user']));
    }

    public function edit(User $user)
    {
     
        $roles = $this->user->getRoles();
        return view('users.edit',compact(['user','roles']));
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $this->user->update($request, $user);
        return redirect('users')->with('success','User ' . $request['name'] . ' successfully updated.');
    }

    public function destroy(User $user)
    {
        $this->user->destroy($user);
        return redirect('users')->with('success','User ' . $user->name . ' successfully removed.');
    }

}
