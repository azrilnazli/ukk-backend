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
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'original_filename',
        'synopsis',
        'duration',
        'downloadable',
        'processing',
        'processing_duration',
        'uploading_duration',
        'public',
        'filesize',
        'width',
        'height',
        'bitrate',
        'job_id',
        'asset_size',
    ];

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
