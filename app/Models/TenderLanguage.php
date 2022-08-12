<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderLanguage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'languages';


    /**
     * The TenderLanguage that belongsToMany to Tender
     */
    public function tenders()
    {
        return $this->belongsToMany(Tender::class);
    }
}
