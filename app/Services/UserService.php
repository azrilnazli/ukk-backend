<?php
namespace App\Services;

use Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserService {

    public function __construct(){}

    public function paginate($perPage=10)
    {
        //return User::role('subscriber')->get();
        //$users = User::role('user')->get();
        //$data = User::orderBy('id','asc')->paginate(10)->setPath('users');
        return User::orderBy('id','desc')->with('company')->paginate($perPage)->setPath('users');
    }


    public function search($request)
    {

        $q = $request->input('query');


        // return Tender::where([['title', 'like', "{$query}%"]])
        //                 ->paginate(10)->setPath('tenders');
       $users = User::query()
                    ->where('email', 'LIKE', '%' . $q . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $q . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $q . '%')

                    ->orWhereHas('company', fn($query) =>
                        $query->where('name', 'LIKE', '%' . $q . '%')
                        ->orWhere('email', 'LIKE', '%' . $q . '%')
                        ->orWhere('phone', 'LIKE', '%' . $q . '%')
                        ->orWhere('address', 'LIKE', '%' . $q . '%')
                        ->orWhere('city', 'LIKE', '%' . $q . '%')
                        ->orWhere('states', 'LIKE', '%' . $q . '%')
                        ->orWhere('postcode', 'LIKE', '%' . $q . '%')
                    )

                    ->orWhereHas('proposals.tender', fn($query) =>
                        $query->where('tender_category', 'LIKE', '%' . $q . '%')
                        ->orWhere('type', 'LIKE', '%' . $q . '%')
                        ->orWhere('channel', 'LIKE', '%' . $q . '%')
                        ->orWhere('programme_code', 'LIKE', '%' . $q . '%')
                    )

                    ->paginate(50)
                    ->setPath(route('users.search'));

                    $users->appends(['search' => $q]);

        return $users;

    }

    public function store($request)
    {
        // $request->validated() from StoreUserRequest
        $user = User::create($request->validated());
        $user->assignRole($request['role']);
        return $user;
    }

    public function register($request)
    {
        // $user = User::create([
        //     'name' => $request['name'],
        //     'password' => Hash::make($request['password']),
        //     'email' => $request['email']
        // ]);

        $user = $this->store($request);

        return  $user->createToken('API Token')->plainTextToken;

    }


    public function update($request, $user)
    {
        if( !empty( $request->input('password') ))
        {
            // assign if true
            $data['password'] = Hash::make($request->input('password'));
        }

        //$data['role'] = $request->input('role');
        $data['name']  = $request->input('name');
        $data['email'] = $request->input('email');

        // update user's role
        if( count( $user->getRoleNames() ) > 0 )
        {
            $user->removeRole($user->roles->first());
        }

        // assign new role
        $user->assignRole($request->input('role'));

        // $request->validated()
        return User::where('id',$user->id)->update($data);
    }

    public function destroy($user)
    {
        User::where('id',$user->id)->delete();
    }



    //$roles = \Spatie\Permission\Models\Role::all();
    //$roles = Role::pluck('name', 'id')->except(['super-admin',1])->toArray();
    //$roles = Role::pluck('name', 'id')->toArray();
    public function getRoles()
    {
        return Role::pluck('name', 'id')->toArray();
    }

}
