<?php 

namespace App\Actions;
use App\Models\Statistics;
use DB;
use App\Actions\Utilities;

class Stats {

    public $user_id;

    public function __construct($user_id){
       $this->user_id = $user_id;
    }
    
    public function all(){
        $utilities = new Utilities();

        // start from statistics table
        $statistics = DB::table('statistics')

        // join all tables
        ->join('videos', 'statistics.video_id', '=', 'videos.id') 
        ->join('video_logs', 'statistics.video_id', '=', 'video_logs.video_id') 

        // select required fields
        ->select(
            
            DB::raw('videos.title'),
            DB::raw('statistics.video_id'), 
           // DB::raw('COUNT(video_logs.id) as pageviews'),
            DB::raw('COUNT(*) as pageviews'),
            DB::raw('SUM(statistics.duration) as duration'),
            DB::raw('SUM(video_logs.responseBytes) as volume')
        )

        // group the data by video_id
        ->groupBy(DB::raw('video_id'))
        

        // belongs to who ?
        ->where('statistics.user_id',$this->user_id) // user_id

        // get the Collection
        ->get()

        // change the element's value
        ->map( function ($value) use ($utilities) {
            return [

                'title'     => $value->title,
                'pageviews' => $value->pageviews,
                'duration'  => $utilities->secondsToMinute($value->duration),
                'volume'    => $utilities->formatBytes($value->volume),
                'bytes'    =>  $value->volume
            ];

        })
        
        // return as PHP Array
        ->toArray();

        return $statistics;
    }    
        
} 