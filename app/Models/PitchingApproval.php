<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingApproval extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * PitchingApproval belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
