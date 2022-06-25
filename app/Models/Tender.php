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

    // protected $casts = [
    //     'languages' => 'array',
    // ];

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
     * Tender belongsTo TenderCategory
     */
    // public function tender_category()
    // {
    //     return $this->belongsTo(TenderCategory::class);
    // }

    /**
     * Tender belongsTo TenderDetail
     */
    public function tender_detail()
    {
        return $this->belongsTo(TenderDetail::class);
    }

    /**
     * The Tenderthat belongsToMany to TenderLanguage
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    // enum | type of tender
    public static function types(){

        $name = 'type';
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

    // enum | language
    // public static function get_languages(){

    //     $name = 'language';
    //     $instance = new Tender; // create an instance of the model to be able to get the table name
    //     $type = DB::select( DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
    //     preg_match('/^enum\((.*)\)$/', $type, $matches);
    //     $enum = array();
    //     foreach(explode(',', $matches[1]) as $value){
    //         $v = trim( $value, "'" );
    //         $enum[] = $v;
    //     }
    //     return $enum;
    // }

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

    // public function setLanguagesAttribute($value)
    // {
    //     $this->attributes['languages'] = json_encode($value);
    // }

    // public function getLanguagesAttribute($value)
    // {
    //     return $this->attributes['languages'] = json_decode($value);
    // }

    // public function getDescriptionAttribute($value)
    // {
    //     return $this->attributes['description'] =nl2br($value);
    // }
}
