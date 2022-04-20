<?php
namespace App\Jobs;

use App\Models\Video;

use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use FFMpeg\FFProbe;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

use romanzipp\QueueMonitor\Traits\IsMonitored; 


class ConvertVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use IsMonitored;

    public $video;
    public $job;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {

        // duration & processing
        $this->video->update([
            'processing' => 1,
            'job_id' => $this->job->uuid(), 
        ]);

        // Start the clock time in seconds 
        $start_time = microtime(true);

        // AES encryption
        //$encryptionKey = HLSExporter::generateEncryptionKey();
        //Storage::disk('streaming')->put($this->video->id . '/m3u8/' . $filename="secret.key", $contents=$encryptionKey);

        // HLS 5
        $media = FFMpeg::fromDisk('assets')->open( $this->video->id . '/original.mp4');
        
        $res_240p = (new X264)->setKiloBitrate(400);
        $res_360p = (new X264)->setKiloBitrate(700);
        $res_480p = (new X264)->setKiloBitrate(1100);
        $res_720p = (new X264)->setKiloBitrate(2500);
        $res_1080p = (new X264)->setKiloBitrate(5000);

        echo "Job id is : " .  $this->job->uuid() . "\n";

        try {
                $media->exportForHLS()
                //->withEncryptionKey($encryptionKey)

                ->withRotatingEncryptionKey
                (
                    function( $filename, $contents)
                    {
                        $path =  $this->video->id . '/secrets/' . $filename;
                        Storage::disk('assets')->put( $path, $contents);
              
                    }
                )
         
                //->addFormat($res_240p, function($media) {
                //    $media->scale(426, 240);
                //})
                ->addFormat($res_360p, function($media) {
                    $media->scale(640, 360);
                })
                ->addFormat($res_480p, function($media) {
                    $media->scale(854, 480);
                })
                ->addFormat($res_720p, function($media) {
                    $media->scale(1280, 720);
                })
                //->addFormat($res_1080p, function($media) {
                //    $media->scale(1920, 1080);
                //})
   
                ->onProgress(function ($percentage) {
                    echo "Exporting to encrypted HLS at  {$percentage}%  \n";
                    Storage::disk('assets')->put( $this->video->id . '/progress.txt' , $percentage);
                })
                ->toDisk('streaming')
                ->save( $this->video->id . '/m3u8/playlist.m3u8');
                $processing = 0; //success
            } catch (EncodingException $exception) {

                $processing = 2; //error
                $command = $exception->getCommand();
                $errorLog = $exception->getErrorOutput();
                $this->video->update([
                    'command' =>$duration,
                    'error' => $width
                ]);
            }

        // thumbnails
        $media = FFMpeg::fromDisk('assets')->open( $this->video->id . '/original.mp4');
        $media->getFrameFromSeconds(2)
            ->export()
            ->toDisk('streaming')
            ->save( $this->video->id . '/thumbnails/image.png');

        // End the clock time in seconds 
        $end_time = microtime(true); 
    
        // Calculate the script execution time 
        $processing_duration = ($end_time - $start_time); 
        
        $media = FFMpeg::fromDisk('assets')->open( $this->video->id . '/original.mp4');
        $duration =  $media->getDurationInSeconds();

        $media = FFMpeg::fromDisk('assets')
        ->open( $this->video->id . '/original.mp4')
        ->getVideoStream()
        ->getDimensions();

        $width  = $media->getWidth();
        $height = $media->getHeight();
        $ratio  = $media->getRatio();


        $file = Storage::disk('assets')->path( $this->video->id .'/original.mp4');
        $ffprobe = FFMpeg\FFProbe::create();
        $bitrate = $ffprobe
            ->format($file) // extracts file informations
            ->get('bit_rate');  

        $file = Storage::disk('assets')->path( $this->video->id .'/original.mp4');
        $ffprobe = FFMpeg\FFProbe::create();
        $format = $ffprobe
            ->format($file) // extracts file informations
            ->get('format_long_name');  
          

        // duration & processing
        $this->video->update([
            'duration' =>$duration,
            'width' => $width,
            'height' => $height,
            'processing' => $processing,
            'processing_duration' => $processing_duration,
            'bitrate' => $bitrate,
            'format' => $format,
        ]);
    }
}