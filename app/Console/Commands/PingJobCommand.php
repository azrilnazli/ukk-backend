<?php

namespace App\Console\Commands;

use App\Jobs\PingJob;
use Illuminate\Console\Command;

class PingJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        for($i=0; $i <= 100; $i++)
        {
            PingJob::dispatch($i);

        }
        echo "Send 100 videos for encoding" . PHP_EOL;
    }
}
