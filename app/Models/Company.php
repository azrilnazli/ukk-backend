<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Profile belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
