<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CompanyApproval extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    use Sortable;
    public $sortable = ['id','status','user_id','created_at','updated_at'];

    /**
     * CompanyApproval belongsTo Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * CompanyApproval belongsTo TenderDetail
     */
    public function tender_detail()
    {
        return $this->belongsTo(TenderDetail::class);
    }

    /**
     * CompanyApproval belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
