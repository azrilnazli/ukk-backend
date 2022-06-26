<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Auth;

class TenderSubmission extends Model
{
    use HasFactory;
    use Sortable;
    public $sortable = ['id', 'created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function tender_detail()
    {
        return $this->belongsTo(TenderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }

    public function allowed_users(){
        return $this->hasMany(Signer::class);
    }

    public function signers(){
        return $this->hasMany(Signer::class)->where('type','=', 'signer');
    }

    public function approved(){
        return $this->hasMany(Scoring::class)->where('syor_status','=',  true);
    }

    public function failed(){
        return $this->hasMany(Scoring::class)->where('syor_status','=',  false);
    }

    public function approval(){
        return $this->hasOne(Approval::class)->where('is_approved','=',  true);
    }


    public function signer(){
        return $this->hasOne(Signer::class);
    }

    public function owner(){
        return $this->belongsTo(User::class, 'added_by');
    }

    public function urusetias(){
        return $this->hasMany(Signer::class)->where('type','=', 'urusetia');
    }

    public function urusetia(){
        return $this->hasOne(Signer::class)->where('type','=', 'urusetia')->where('user_id','!=', Auth::user()->id);
    }

    public function scorings(){
        return $this->hasMany(Scoring::class);
    }

    public function verifications(){
        return $this->hasMany(Verification::class);
    }

    public function score(){
        return $this->hasOne(Scoring::class)->where('user_id', Auth::user()->id);
    }
}
