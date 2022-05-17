<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the Statistics belongs to that Video     */
    public function statistics()
    {
        return $this->hasMany(Statistics::class);
    }
}
