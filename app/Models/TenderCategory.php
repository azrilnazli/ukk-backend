<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * TenderCategory hasMany Tender
     */
    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

}
