<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'firstname',
    //     'lastname',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * User hasOne Video
     */
    public function video()
    {
        return $this->hasOne(Video::class)->orderBy('id', 'desc');
    }

    /**
     * User hasMany Videos
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * User hasMany Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * User hasOne Profile
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * User hasOne Company
     */
    public function company()
    {
        //return $this->hasOne(Company::class)->where('is_approved', true);
        return $this->hasOne(Company::class);
    }

    public function approved_company()
    {
          return $this->hasOne(Company::class)->where('is_approved', true);
        //return $this->hasOne(Company::class);
    }

    /**
     * User hasMany Proposal
     */
    public function proposals()
    {
        return $this->hasMany(TenderSubmission::class);
    }

    /**
     * User hasMany Proposal
     */
    public function messages()
    {
        return $this->hasMany(Comment::class);
    }

    public function verification()
    {
       // return $this->hasOne(Company::class)->where('is_approved','=', 1);
        return $this->hasOne(Verification::class);
    }
}
