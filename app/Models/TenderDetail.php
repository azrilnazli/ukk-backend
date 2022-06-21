<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * The TenderRequirement that belong to the TenderDetail.
     */
    public function tender_requirements()
    {
        return $this->belongsToMany(TenderRequirement::class);
    }

    /**
     * The TenderDetail hasMany CompanyApproval.
     */
    public function company_approvals()
    {
        return $this->hasMany(CompanyApproval::class);
    }
}
