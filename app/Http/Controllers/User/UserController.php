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
use Route;
use Spatie\Activitylog\Contracts\Activity;

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

    static function routes()
    {
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::resource('users', UserController::class );
    }

    public function index()
    {


        $data = $this->user->paginate(50);
        return view('users.index',compact(['data']));
    }

    public function search(Request $request){

        $data = $this->user->search($request);
        activity()
        // ->tap(function(Activity $activity) use ($request) {
        //     $activity->query = $request->input('query');
        //  })
        ->log('User Search :' . $request->input('query') );

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
        activity()->log('User Create');
        return redirect('users')->with('success','User ' . $request['name'] . ' added.');
    }

    public function show(User $user)
    {

        return view('users.show',compact(['user']));
    }

    public function edit(User $user)
    {

        $roles = $this->user->getRoles();
        activity()->log('User Edit');
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
