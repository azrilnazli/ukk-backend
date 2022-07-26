<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreeningScoring extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = array('total_score');

    public function getTotalScoreAttribute()
    {
        $score = (
                    $this->criteria +
                    $this->storyline +
                    $this->creativity +
                    $this->technical +
                    $this->acting +
                    $this->value_added

                );
        return $score;
    }


    public function tender_submission()
    {
        return $this->belongsTo(TenderSubmission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function screening_urusetia()
    {
        return $this->belongsTo(ScreeningUrusetia::class);
    }

    public function screening_signer()
    {
        return $this->belongsTo(ScreeningSigner::class);
    }
}
