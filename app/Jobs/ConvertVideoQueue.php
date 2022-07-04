<?php
namespace App\Jobs;

use App\Models\Video;
use Config;
use File;
use Log;

use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use FFMpeg\FFProbe;
use App\Jobs\ConvertVideoQueue;

// use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use romanzipp\QueueMonitor\Traits\IsMonitored;


class ConvertVideoQueue implements ShouldQueue,ShouldBeUnique
{
    use IsMonitored,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public $backoff = 3; // 3 secs before retrying
    public $video;
    public $job;
    public $width;
    public $height;
    public $bitrate;
    public $quality;
    public $startTime;

    public function __construct(Video $video)
    {
        $this->video = \App\Models\Video::find($video->id);
        $this->startTime = microtime(true);
    }

    public function handle()
    {

        // echo $this->job->getJobId();
        if($this->video->company){
            echo "Job sent by " . $this->video->company->name . " [ id-".$this->video->id."]" . PHP_EOL;
        }else{
            echo "Job sent by " . $this->video->user->email . " [ id-".$this->video->id."]" . PHP_EOL;
        }

        $media = FFMpeg::fromDisk('assets')->open( $this->video->id . '/original.mp4');
        $duration =  $media->getDurationInSeconds();
        // Update Video Model
        $this->video->update([
            'is_reencode' => false,
            'is_failed' => false,
            'is_ready' => false,
            'is_processing' => true,

            'duration' => $duration,
            'job_id' => $this->job->uuid() // to match with failed jobs
        ]);


        // encode video to multibitrate
        $this->createMultiBitrate($this->video->id);

        // create master playlist.m3u8
        $this->createMasterPlaylist($this->video->id);

        // thumbnails
        $this->createThumbnail($this->video->id);

        // db update
        $this->updateMetadata($this->video->id);

    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed($exception)
    {

        // get Video collection
        $video = \App\Models\Video::find($this->video->id);

        // Update Video Model
        $video->update([
            'is_reencode' => true, // send for reencode
            'is_failed' => false,
            'is_ready' => false,
            'is_processing' => false,
            'exception' => $exception,
        ]);

        // send to ConvertVideoFailed
        $job =  ( new \App\Jobs\ConvertVideoFailed($video) )->onQueue('failed_jobs')->onConnection('database'); // Dispatchable
        dispatch($job);

        // delete existing job from onQueue('default')
        $this->delete(); // InteractsWithQueue


        // send failed job to onQueue('failed_jobs')
        //$this->dispatch(\App\Models\Video::find($this->video->id))->onQueue('failed_jobs'); // Dispatchable
    }


    function createMultiBitrate($id){
        // from config
        $profiles = collect(Config::get('laravel-ffmpeg.profiles'));

        // iterate each item and encode
        $profiles->each(function($item, $key) use ($id) {
            $this->encode($id, $key,$item['bitrate'],$item['width'],$item['height']);
        });
    }

    function updateMetadata($id){

        $media = FFMpeg::fromDisk('assets')->open( $id . '/original.mp4');
        $duration =  $media->getDurationInSeconds();

        $media = FFMpeg::fromDisk('assets')
        ->open( $id . '/original.mp4')
        ->getVideoStream()
        ->getDimensions();

        $width  = $media->getWidth();
        $height = $media->getHeight();
        $ratio  = $media->getRatio();

        $file = Storage::disk('assets')->path( $id .'/original.mp4');
        $ffprobe = FFMpeg\FFProbe::create();
        $bitrate = $ffprobe
            ->format($file) // extracts file informations
            ->get('bit_rate');

        $file = Storage::disk('assets')->path( $id .'/original.mp4');
        $ffprobe = FFMpeg\FFProbe::create();
        $format = $ffprobe
            ->format($file) // extracts file informations
            ->get('format_long_name');

        //Log::info($format);

        // Calculate the script execution time
        // End the clock time in seconds
        $end_time = microtime(true);
        $processing_duration = ($end_time - $this->startTime);

        // duration & processing

        //$video =  Video::find($this->video->id);

        $this->video->update([
            'duration' =>$duration,
            'width' => $width,
            'height' => $height,

            'processing_duration' => $processing_duration,
            'bitrate' => $bitrate,
            'format' => $format,
            'asset_size' => $this->getFolderSize($id),
            'job_id' => $this->job->uuid(), // to match with failed jobs

            'is_reencode' => false,
            'is_failed' => false,
            'is_ready' => true,
            'is_processing' => false,
        ]);

        // $this->video->proposal->update([
        //     'is_video' => 1,
        // ]);
    }

    function getFolderSize($id){
        $file_size = 0;
        foreach( File::allFiles(public_path('/storage/streaming/' . $id )) as $file)
        {
            $file_size += $file->getSize(); // KB
        }

        return $file_size = number_format($file_size / 1048576,2); // MB
    }

    function createThumbnail($id){

        $media = FFMpeg::fromDisk('assets')->open( $id . '/original.mp4');
        $media->getFrameFromSeconds(2)
            ->export()
            ->toDisk('streaming')
            ->save( $id . '/thumbnails/poster.jpg');
    }

    function createMasterPlaylistOld($id){
        # create master playlist
        $header = "#EXTM3U";
        $footer = "#EXT-X-ENDLIST";

        $file = $id ."/m3u8/playlist.m3u8";//the path of your file
        $conn = Storage::disk('streaming');//configured in the file filesystems.php
        $stream = $conn->readStream($file);

        while (($line = fgets($stream, 4096)) !== false)
        {
            //$line is the string var of your line from your file
            $rows[] = $line;
        }

        array_unshift($rows, $header); // put $header on top of the collection
        array_push($rows, $footer);  // put $footer on bottom of the collection
        $playlist = implode("\n", $rows); // array to raw wirh \n ad delimiter
        $playlist = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $playlist); // remove empty line
        Storage::disk('streaming')->put( $id . "/m3u8/playlist.m3u8" , $playlist); // write to disk
    }

    function createMasterPlaylist($id){
        $header = "#EXTM3U";
        $footer = "#EXT-X-ENDLIST";

        $file = $id ."/m3u8/playlist.m3u8"; //playlist.m3u8 path
        $conn = Storage::disk('streaming'); //which disk
        $stream = $conn->readStream($file);

        $collection = collect(); // initialize empty collection
        // put $header on top of the collection
        $collection->prepend($header);
        while (($line = fgets($stream, 4096)) !== false) // iterate playlist.m3u8 line by line
        {
            $collection->push($line); // push every line into $collection
        }
        // put $footer on bottom of the collection
        $collection->push($footer);

        // write to file
        Storage::disk('streaming')->put(
            $location = $id . "/m3u8/playlist.m3u8" ,
            $contents = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n",  $collection->implode("\n")
        ));
    }

    function encode($id, $quality,$bitrate,$width,$height){

        $this->quality  = $quality;
        $this->bitrate  = $bitrate;
        $this->width    = $width;
        $this->height   = $height;

        // HLS 5
        $media = FFMpeg::fromDisk('assets')->open( $id . '/original.mp4');

        $quality = (new X264)->setKiloBitrate($this->bitrate);

        $media->exportForHLS()
        //->withEncryptionKey($encryptionKey)

        // disable encryption
        // ->withRotatingEncryptionKey
        // (
        //     function( $filename, $contents) use ($id)
        //     {
        //         $path =  $id . '/secrets/' . $filename;
        //         Storage::disk('assets')->put( $path, $contents);
        //     }
        // )

        ->addFormat
        (
            $quality,
            function($media)
            {
                $media->scale($this->width, $this->height);
            }
        )


        ->onProgress
        (
            function ($percentage) use ($id)
            {

                // write to file
                // echo "Exporting to encrypted HLS for $this->quality at  {$percentage}%  \n";
                Storage::disk('assets')->put( $id . "/progress_$this->quality.txt" , $percentage);
                Storage::disk('streaming')->put( $id . "/progress_$this->quality.txt" , $percentage);

                // store to db
                $quality = $this->quality;


                // 5 profiles each is 20%
                $previous = 0;
                if($quality == '240p'){

                    $total = ($percentage/5);
                    Storage::disk('assets')->put( $id . "/progress_all.txt" , $total);
                    Storage::disk('streaming')->put( $id . "/progress_all.txt" , $total);

                    //echo "TOTAL :: Exporting to encrypted HLS for $quality at  {$total}%  \n";
                }

                if($quality == '360p'){

                    $previous = 20;
                    $total = (($percentage/5) + $previous);
                    Storage::disk('assets')->put( $id . "/progress_all.txt" , $total);
                    Storage::disk('streaming')->put( $id . "/progress_all.txt" , $total);

                    //echo "TOTAL :: Exporting to encrypted HLS for $quality at  {$total}%  \n";
                }

                if($quality == '480p'){

                    $previous = 40;
                    $total = (($percentage/5) + $previous);
                    Storage::disk('assets')->put( $id . "/progress_all.txt" , $total);
                    Storage::disk('streaming')->put( $id . "/progress_all.txt" , $total);

                    //echo "TOTAL :: Exporting to encrypted HLS for $quality at  {$total}%  \n";
                }

                if($quality == '720p'){

                    $previous = 60;
                    $total = (($percentage/5) + $previous);
                    Storage::disk('assets')->put( $id . "/progress_all.txt" , $total);
                    Storage::disk('streaming')->put( $id . "/progress_all.txt" , $total);

                    //echo "TOTAL :: Exporting to encrypted HLS for $quality at  {$total}%  \n";
                }

                if($quality == '1080p'){

                    $previous = 80;
                    $total = (($percentage/5) + $previous);
                    Storage::disk('assets')->put( $id . "/progress_all.txt" , $total);
                    Storage::disk('streaming')->put( $id . "/progress_all.txt" , $total);

                    //echo "PROGRESS {$id} :: Exporting to encrypted HLS for {$quality} at  {$total}%  \n";
                }

                echo "VIDEO ID ({$id}) :: Exporting to encrypted HLS for {$quality} at  {$total}%  \n";


                // write to progress_all.txt
            // Storage::disk('assets')->put( $id . "/progress_all.txt" , $total);
            }
        )
        ->toDisk('streaming')
        ->save( $id . "/m3u8/playlist_$this->quality.m3u8");

        $header = "#EXTM3U";
        $footer = "#EXT-X-ENDLIST";

        $file = $id ."/m3u8/playlist_$this->quality.m3u8";//the path of your file
        $conn = Storage::disk('streaming');//configured in the file filesystems.php
        $stream = $conn->readStream($file);

        while (($line = fgets($stream, 4096)) !== false)
        {
            //$line is the string var of your line from your file
            $line = str_replace("#EXTM3U", "", $line);
            $line = str_replace("#EXT-X-ENDLIST", "", $line);

            $rows[] = $line;
        }

        // create new playlist based on quality
        $playlist = implode("\n", $rows);
        Storage::disk('streaming')->append( $id . "/m3u8/playlist.m3u8" , $playlist);
    }
}
