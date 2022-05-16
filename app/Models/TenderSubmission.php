<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderSubmission extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    /**
     * TenderSubmission belongsTo Tender
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }


    /**
     * TenderSubmission belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    /**
     * TenderSubmission hasOne Video
     */
    public function video()
    {
        return $this->hasOne(Video::class);
    }
}
