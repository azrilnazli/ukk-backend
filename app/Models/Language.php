<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    /**
     * The TenderLanguage that belongsToMany to Tender
     */
    public function tenders()
    {
        return $this->belongsToMany(Tender::class);
    }
}
