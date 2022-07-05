<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingSigner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tender_submission()
    {
        return $this->belongsTo(TenderSubmission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function urusetia()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

}
