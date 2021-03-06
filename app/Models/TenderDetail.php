<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = array('expired');

    /**
     * Get the end date.
     *
     * @return string
     */

    public function getExpiredAttribute()
    {
        return \Carbon\Carbon::parse($this->end)->diffForHumans();
    }

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

    /**
     * The TenderDetail hasMany CompanyApproval.
     */
    public function company_approvals_approved()
    {
        return $this->hasMany(CompanyApproval::class)->where('is_approved', TRUE);
    }

    /**
     * TenderDetail hasMany Tender
     */
    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    /**
     * TenderDetail hasMany TenderSubmission
     */
    public function tender_submissions()
    {
        return $this->hasMany(TenderSubmission::class);
    }


}
