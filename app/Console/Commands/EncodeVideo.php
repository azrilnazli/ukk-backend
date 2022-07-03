<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use File;


class EncodeVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:encode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encode video for streaming';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            // process all failed videos on queue=encode
            // ['created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString()]
            $videos = \App\Models\Video::query()
                        //->where('is_processing', true)
                        ->where('is_reencode', true)
                        //->where('updated_at', '>=' , \Carbon\Carbon::now()->addHours(2)->toDateTimeString() )
                        ->get();
            foreach($videos as $video){
                echo "Dispatch video=" .$video->id. " to re-encode".PHP_EOL;

                $v = \App\Models\Video::find($video->id);
                $v->is_reencode = true;
                $v->is_failed = false;
                $v->is_processing = true;
                $v->is_ready = false;
                $v->save();

                $job =  ( new \App\Jobs\ConvertVideoQueue($video) )->onQueue('encode')->onConnection('database'); // Dispatchable
                dispatch($job);
            }

    }
}
