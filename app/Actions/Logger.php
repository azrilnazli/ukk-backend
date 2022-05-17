<?php 

namespace App\Actions;

use Illuminate\Http\Request; 
use App\Models\Statistics;

use Exception;
use Log;

use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\DB;
use App\Models\VideoLog;


class Logger {


    // contstructor
    public function __construct(){
     
    }

    // store video usage in statistics table
    // data came from ReactJS Video.JS callback
    // expecting $request data
    function storeVideoPlayerUsage(Request $request)
    {

        //$user_id = $request->user()->id; // provided by Sanctum

        try {

            $stat = Statistics::firstOrNew( array('timestamp' => $request['timestamp']) );
            $stat->duration = $request['duration'];
            $stat->user_id =  $request->user()->id;
            $stat->video_id = $request['video_id'];
            //Log::info("Stored in DB for user " . $request->user()->id . " updated duration " . $request['duration'] . " for video " .  $request['video_id'] );
            return $stat->save();
            
        }
        catch(Exception $e){
            return $e->getMessage();
        }
  
    }

    // process video log from apache access_log
    // modify pattern based on new line ( windows or linux )
    function processLog()
    {

        //$regex = "/^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) (\".*?\") (\".*?\")(\r?\n)$/"; 
  
        $log = 'C:\laragon\bin\apache\httpd-2.4.47-win64-VS16\logs\access.log';
        // 127.0.0.1 - - [14/Mar/2022:13:36:01 +0800] "GET /storage/streaming/12/m3u8/playlist_720p_0_2500_00010.ts HTTP/1.1" 200 769312
        $regex = '@^(\S+)\ (\S+) (\S+) \\[(.*?)\\] \\"GET \/storage\/streaming\/(.*?)\/m3u8\/(.*?).ts\?access_token\=(.*?) HTTP/1.1\\" (\S+) (\S+)(\r?\n)$@';

        LazyCollection::make(function () use ($log){
           
            $handle = fopen($log, 'r');
            
            while (($line = fgets($handle)) !== false){
                yield $line;    
            }
            })->each(function ($line) use ($regex) 
            {
   
               // echo $line . PHP_EOL;
                if (preg_match($regex,$line,$matches)){
                    //echo 'match' . PHP_EOL;
                    $d = $matches[4];
                    $time = date("Y-m-d H:i:s", strtotime($d));

                    // get video_id
                    $video_id = $matches[5];

                    // get bitrate
                    $r = explode('_',$matches[6]);
                    $bitrate = $r[1];

                    // get user_id
                    $r = explode('|',$matches[7]);
                    $token = $r[1];
                    $token_data = DB::table('personal_access_tokens')
                                    ->where('token', hash('sha256', $token))
                                    ->first();
                    
                    //print_r($token_data);
                    $user_id = 0;
                    if($token_data){
                        $user_id = $token_data->tokenable_id;
                    }
                   
                    $request = $matches[0];
                    $status = $matches[8];
                    $responseBytes = $matches[9];
     
                    $log = VideoLog::firstOrNew( 
                                            [
                                                'request' => $request, // check before insert
                                            ] 
                                        );
                    $log->time = $time;
                    $log->user_id =  $user_id;
                    $log->video_id = $video_id;
                    $log->bitrate = $bitrate;
                    $log->request = $request;
                    $log->status = $status;
                    $log->responseBytes = $responseBytes;
                    $log->save();

                }
            });
        
    } // processLog()
    
} 