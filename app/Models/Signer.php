<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Signer belongsTo Scoring
     */
    public function scoring()
    {
        return $this->belongsTo(Scoring::class);
    }

    /**
     * Signer belongsTo TenderSubmission
     */
    public function proposal()
    {
        return $this->belongsTo(TenderSubmission::class);
    }


}
