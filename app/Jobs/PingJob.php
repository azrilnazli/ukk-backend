<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $number;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $number)
    {
        //
        $this->number = $number;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        return $this->number
      
    }
}
