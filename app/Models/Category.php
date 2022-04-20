<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /**
     * Category HasMany Videos
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    } 

    /**
     * Category belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}