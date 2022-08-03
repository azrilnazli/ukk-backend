<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Auth;
use OwenIt\Auditing\Contracts\Auditable;

class TenderSubmission extends Model
{
    use HasFactory;
    use Sortable;
    public $sortable = ['id', 'created_at', 'updated_at'];
    protected $guarded = ['id'];


    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
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
        return $this->hasOne(Video::class)->orderBy('id','DESC');
    }

    public function allowed_users(){
        return $this->hasMany(Signer::class);
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


    // public function signer(){
    //     return $this->hasOne(Signer::class);
    // }

    // ownser is urusetia-1
    public function owner(){
        return $this->belongsTo(User::class, 'added_by');
    }

    // another urusetia is urusetia-2
    public function urusetia(){
        return $this->hasOne(Signer::class)->where('type','=', 'urusetia')->where('user_id','!=', Auth::user()->id);
    }

    // signers
    public function signers(){
        return $this->hasMany(Signer::class)->where('type','=', 'signer');
    }

    // urusetia
    public function urusetias(){
        return $this->hasMany(Signer::class)->where('type','=', 'urusetia');
    }

    public function scorings(){
        return $this->hasMany(Scoring::class);
    }

    public function verifications(){
        return $this->hasMany(Verification::class);
    }

    // score by penanda
    public function my_score(){
        return $this->hasOne(Scoring::class)->where('user_id', Auth::user()->id);
    }

    // verification by urusetia
    public function my_verification(){
        return $this->hasOne(Verification::class)->where('user_id', Auth::user()->id);
    }

    // approval by ketua
    public function my_approval(){
        return $this->hasOne(Approval::class)->where('user_id', Auth::user()->id);
    }

    // hasOne PitchingOwner
    public function pitching_owner(){
        return $this->hasOne(PitchingOwner::class);
    }

    // hasMany PitchingSigner
    public function pitching_signers(){
        return $this->hasMany(PitchingSigner::class);
    }

    // hasMany PitchingUrusetia
    public function pitching_urusetias(){
        return $this->hasMany(PitchingUrusetia::class);
    }

    // hasMany PitchingScorings
    public function pitching_scorings(){
        return $this->hasMany(PitchingScoring::class);
    }
    public function pitching_scoring(){
        return $this->hasOne(PitchingScoring::class)->where('user_id', Auth::user()->id);
    }

    // hasMany PitchingVerifications
    public function pitching_verifications(){
        return $this->hasMany(PitchingVerification::class);
    }

    // hasOne PitchingVerification
    public function pitching_verification(){
        return $this->hasOne(PitchingVerification::class);
    }

    // hasMany PitchingApprovals
    public function pitching_approvals(){
        return $this->hasMany(PitchingApproval::class);
    }


    // hasOne PitchingApproval
    public function pitching_approval(){
        return $this->hasOne(PitchingApproval::class);
    }


    ### SCREENING - start ###
    // hasOne PitchingOwner
    public function screening_owner(){
        return $this->hasOne(ScreeningOwner::class);
    }

    // hasMany ScreeningSigner
    public function screening_signers(){
        return $this->hasMany(ScreeningSigner::class);
    }

    // hasMany ScreeningUrusetia
    public function screening_urusetias(){
        return $this->hasMany(ScreeningUrusetia::class);
    }

    // hasMany ScreeningScorings
    public function screening_scorings(){
        return $this->hasMany(ScreeningScoring::class);
    }

    public function screening_scoring(){
        return $this->hasOne(ScreeningScoring::class)->where('user_id', Auth::user()->id);
    }

    // hasMany ScreeningVerifications
    public function screening_verifications(){
        return $this->hasMany(ScreeningVerification::class);
    }

    // hasOne ScreeningVerification
    public function screening_verification(){
        return $this->hasOne(ScreeningVerification::class);
    }

    // hasOne ScreeningApproval
    public function screening_approval(){
        return $this->hasOne(ScreeningApproval::class);
    }

    // hasMany ScreeningApproval
    public function screening_approvals(){
        return $this->hasMany(ScreeningApproval::class);
    }
    ### SCREENING - end   ###


}
