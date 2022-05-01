<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Comment belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
