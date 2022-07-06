<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingScoring extends Model
{
    use HasFactory;


    /**
     * Company belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
