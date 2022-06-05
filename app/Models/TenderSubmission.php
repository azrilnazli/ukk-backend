<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class TenderSubmission extends Model
{
    use HasFactory;
    use Sortable;
    public $sortable = ['id', 'created_at', 'updated_at'];
    protected $guarded = ['id'];


    /**
     * TenderSubmission belongsTo Tender
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }


    /**
     * TenderSubmission belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    /**
     * TenderSubmission hasOne Video
     */
    public function video()
    {
        return $this->hasOne(Video::class);
    }

    public function signers(){
        return $this->hasMany(Signer::class)->where('type','=', 'signer');
    }

    public function urusetia(){
        return $this->hasMany(Signer::class)->where('type','=', 'urusetia');
    }
}
