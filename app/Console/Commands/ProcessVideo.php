<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

use Illuminate\Support\Facades\Storage;

class ProcessVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encode MP4 to Encrypted HLS';

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
        echo "Start encoding " . PHP_EOL;
        echo "************** " . PHP_EOL;
        
          // HLS 5
          $media = FFMpeg::fromDisk('uploads')->open('original.mp4');
        
          $res_240p = (new X264)->setKiloBitrate(400);
          $res_360p = (new X264)->setKiloBitrate(700);
          $res_480p = (new X264)->setKiloBitrate(1100);
          $res_720p = (new X264)->setKiloBitrate(2500);
          $res_1080p = (new X264)->setKiloBitrate(5000);
  
          $media->exportForHLS()
                  //->withEncryptionKey($encryptionKey)
  
                  ->withRotatingEncryptionKey
                  (
                      function( $filename, $contents)
                      {
                         // $path =  $this->video->id . '/secrets/' . $filename;
                          Storage::disk('secrets')->put( $filename, $contents);
                
                      }
                  )
           
                  ->addFormat($res_240p, function($media) {
                      $media->scale(426, 240);
                  })
                  ->addFormat($res_360p, function($media) {
                      $media->scale(640, 360);
                  })
                  ->addFormat($res_480p, function($media) {
                      $media->scale(854, 480);
                  })
                  ->addFormat($res_720p, function($media) {
                      $media->scale(1280, 720);
                  })
                  ->addFormat($res_1080p, function($media) {
                      $media->scale(1920, 1080);
                  })
     
                  ->onProgress(function ($percentage) {
                      echo "HLS {$percentage}% processed \n";
                  })
                  ->toDisk('public')
                  ->save( 'videos/playlist.m3u8');
    }
}
