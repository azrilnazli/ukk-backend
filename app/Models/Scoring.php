<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoring extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Scoring belongsTo TenderSubmission
     */
    public function proposal()
    {
        return $this->belongsTo(TenderSubmission::class);
    }

    /**
     * Scoring belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scoring belongsTo Tender
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }    

    /**
     * Scoring belongsTo Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tender_submissions()
    {
        return $this->belongsTo(TenderSubmission::class);
    }




}
