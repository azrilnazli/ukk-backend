<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Statistics extends Model
{
    use HasApiTokens, HasFactory;
    protected $guarded = ['id'];
    
    /**
     * Video belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   /**
     * Get the Category that owns the Video.
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
