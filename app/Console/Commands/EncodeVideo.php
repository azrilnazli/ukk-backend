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
            $videos = \App\Models\Video::query()
                        ->where('is_processing', true)
                        ->get();
            foreach($videos as $video){
                echo "Dispatch" .$video->id. " to re-encode".PHP_EOL;
                $job =  ( new \App\Jobs\ConvertVideoQueue($video) )->onQueue('encode')->onConnection('database'); // Dispatchable
                dispatch($job);
            }

    }
}
