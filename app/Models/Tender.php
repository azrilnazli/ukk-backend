<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Category belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
    public static function languages(){
        
        $name = 'language';
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
