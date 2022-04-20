<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

use Validator;
use Image;
use Hash;

use Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get current user profile
        $user = User::find(Auth::user()->id);
        $avatar = null;
        
        if(Storage::disk('public')->exists("/avatars/" . Auth::user()->id . '.png')){
            $avatar = Storage::disk('public')->url("/avatars/" . Auth::user()->id . '.png');
        }

        // return the view
        return view('profile.index', compact('user') )->with('avatar',$avatar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfileRequest $request)
    {

        // User
        $user = User::find(Auth::user()->id);
        $user->name = $request['name'];
        if( !empty( $request->input('password') ))
        {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        // Profile 
        $profile = Profile::firstOrNew(['user_id' =>  Auth::user()->id ]);
        $profile->phone = $request['phone'];
        $profile->address = $request['address'];
        

        // Photo
        if($request->hasFile('imgupload'))
        {
            //dd($request->imgupload);
            $request->file('imgupload')->storeAs(
                'avatars', // folder
                Auth::user()->id . '.png', // path Storage::disk('public')->url("/avatars/" . Auth::user()->id . '.png'
                'public' // disk
            );

            $file = Storage::disk('public')->path( '/avatars/' .  Auth::user()->id . '.png' );
            $dest = Storage::disk('public')->path( '/avatars/' .  Auth::user()->id . '.png' );

            // resize
            $poster = Image::make($file);
            $poster->resize(300,300);
            $poster->save($dest);

            // update DB
            $profile->photo = 1; // user upload photo
        }

        $profile->save(); // save profile
        return redirect('profile')->with('success','Your profile was updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        //
    }


}
