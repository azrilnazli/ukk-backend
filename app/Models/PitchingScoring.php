<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingScoring extends Model
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

    public function pitching_urusetia()
    {
        return $this->belongsTo(PitchingUrusetia::class);
    }

    public function pitching_signer()
    {
        return $this->belongsTo(PitchingSigner::class);
    }

}
