<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningVerification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * ScreeningVerification belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
