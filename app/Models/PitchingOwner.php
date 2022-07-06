<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingOwner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    /**
     * Company belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
