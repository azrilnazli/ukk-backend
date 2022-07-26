<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningUrusetia extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    /**
     * ScreeningUrusetia belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
