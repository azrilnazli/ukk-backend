<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scoring()
    {
        return $this->belongsTo(Scoring::class);
    }

    public function tender_submission()
    {
        return $this->belongsTo(TenderSubmission::class)->where('is_approved',true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
