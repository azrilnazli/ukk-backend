<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use App\Models\User;
use App\Models\Profile;
use App\Traits\ApiResponser;
//use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;

// Form Validation
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\EmailRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Http\Requests\Auth\CheckPasswordRequest;
use App\Http\Requests\Auth\NewPasswordRequest;

// User Service
use App\Services\UserService;
use Route;


class AuthController extends Controller
{
    use ApiResponser;


    function __construct()
    {
        $this->user = new UserService;
        //$this->user_id =  $request->user()->id;
    }

    static function guestRoutes(){
        Route::middleware('guest')->post('/auth/register', [AuthController::class, 'register']);
        Route::middleware('guest')->post('/auth/login', [AuthController::class, 'login']);
        Route::middleware('guest')->post('/password/email', [AuthController::class, 'email']);
        Route::middleware('guest')->post('/password/reset', [AuthController::class, 'reset_password']);
    }

    static function routes(){
        // user
        Route::post('/user/update', [AuthController::class, 'update']);
        Route::get('/user/my_account', [AuthController::class, 'my_account']);
        Route::post('/user/check_password', [AuthController::class, 'check_password']);
        Route::post('/user/new_password', [AuthController::class, 'new_password']);
        Route::get('/user/statistics', [MovieController::class, 'statistics']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

    }

    public function register(RegisterRequest $request)
    {

        $request['role'] = 'pembekal';
        $token = $this->user->register($request);

        return $this->success([
            'token' => $token
        ]);

    }

    public function login(LoginRequest $request)
    {

        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function email(EmailRequest $request)
    {

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? response()->json($status,200) // success
        : response()->json($status,422); // failed

    }


    public function reset_password(ResetRequest $request)
    {

        // success in validation, now reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                //$user->tokens()->delete(); // delete the token in DB

                event(new PasswordReset($user));
            }
        );

        // success
        if($status == Password::PASSWORD_RESET){
            return response([
                'message' => 'Password reset successfully'
            ]);

        }

        // error
        return response([
            'message' => __($status)
        ],422);
    }

    // handle user profile update
    public function update(UpdateRequest $request){
        // save to DB
        $user = User::find(auth()->user()->id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->save();

        // // Profile
        $profile = Profile::firstOrNew(['user_id' => auth()->user()->id ]);
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->postcode = $request->postcode;
        $profile->city = $request->city;
        $profile->states = $request->states;
        $profile->save();


        // JSON response
        return response([
            'message' => 'Account updated',
            'request' => $request->all()
        ]);
    }

    public function my_account(){
        // start from statistics table
        $user = DB::table('users')
        // join all tables
        ->join('profiles', 'profiles.user_id', '=', 'users.id')
        // select required fields
        ->select(
            DB::raw('users.firstname'),
            DB::raw('users.lastname'),
            DB::raw('users.email'),
            DB::raw('profiles.phone'),
            DB::raw('profiles.address'),
            DB::raw('profiles.postcode'),
            DB::raw('profiles.city'),
            DB::raw('profiles.states'),
        )
        // belongs to who ?
        ->where('users.id', auth()->user()->id) // user_id
        // get the Collection
        ->first();

        $user ?
            $message = response([
                'firstname' => $user->firstname  ,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'postcode' => $user->postcode,
                'city' => $user->city,
                'states' => $user->states,
            ])
        :
            $message = response([
                'message' => 'not exist' ,

            ]);

            return $message;
    }

    public function check_password(CheckPasswordRequest $request)
    {

            $credentials = [
                'email' =>auth()->user()->email,
                'password' =>  $request->current_password,
            ];

            if (!Auth::guard('web')->attempt($credentials)) {
                return response([
                    'message' => 'Wrong password'
                ],401);
            }

            return $this->success([
                'email'   => auth()->user()->email,
                'message' => 'Authenticated'
            ]);

    }

    public function new_password(NewPasswordRequest $request)
    {

            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->password);
            $user->save();

            // if (!$user->save()) {
            //     return response([
            //         'message' => 'Cannot update password'
            //     ],401);
            // }

            return $this->success([
                'message' => 'Password change is successful'
            ]);
    }
}
