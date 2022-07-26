<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingVerification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    /**
     * PitchingVerification belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
