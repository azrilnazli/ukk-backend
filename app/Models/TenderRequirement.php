<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderRequirement extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * The TenderDetail that belong to the TenderRole.
     */
    public function tender_details()
    {
        return $this->belongsToMany(TenderDetail::class);
    }
}
