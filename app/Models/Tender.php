<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Tender extends Model
{
    use HasFactory;
    use Sortable;
    public $sortable = ['id','tender_category','programme_code', 'created_at', 'updated_at'];
    protected $guarded = ['id'];


    /**
     * Category belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tender hasMany Proposal
     */
    public function proposals()
    {
        return $this->hasMany(TenderSubmission::class);
    }


    /**
     * Tender belongsTo TenderDetail
     */
    public function tender_detail()
    {
        return $this->belongsTo(TenderDetail::class);
    }

    /**
     *  Tender belongsToMany to Language
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }



    // enum | duration
    public static function duration(){

        $name = 'duration';
        $instance = new Tender; // create an instance of the model to be able to get the table name
        $type = DB::select( DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach(explode(',', $matches[1]) as $value){
            $v = trim( $value, "'" );
            $enum[] = $v;
        }
        return $enum;
    }



    // enum | channel
    public static function channels(){

        $name = 'channel';
        $instance = new Tender; // create an instance of the model to be able to get the table name
        $type = DB::select( DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach(explode(',', $matches[1]) as $value){
            $v = trim( $value, "'" );
            $enum[] = $v;
        }
        return $enum;
    }


}
