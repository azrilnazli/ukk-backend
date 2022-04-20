<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use File;

class CopyVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:copy';

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
        $videos = \App\Models\Video::all()->where('id','!=' , 3 );
        foreach($videos as $video){
            echo 'Creating assets for : ' . $video->id . PHP_EOL;
            
        // create folder for handling assets for private and public
        $collection = collect([
            ['disk' => 'assets',    'folders' => ['mp4','secrets'] ],
            ['disk' => 'streaming', 'folders' => ['m3u8','images', 'thumbnails'] ],         
        ]);
        
        $disks = $collection->pluck('disk')->each(function ($item,$key) use ($collection, $video) {
            // create master folder
            Storage::disk($item)->makeDirectory( $video->id ); // make primary folder
            // iterate using disk value from pluck() above
            $collection->where('disk', $item)->each( function ($item, $key) use ($collection, $video) {
                // create folders      
                foreach( $item['folders'] as $folder){
                   Storage::disk($item['disk'])->makeDirectory( $video->id . '/' . $folder);
                }
            });
         });

        // copy master file
         
        //$file = Storage::disk('assets')->path( '1/original.mp4');
        $file = Storage::disk('public')->path('/src/original.mp4');
        $dest = Storage::disk('assets')->path($video->id . '/original.mp4');
        File::copy($file,$dest);
           
        // copy from video id =3
        //$file = Storage::disk('streaming')->path('1/m3u8');
        $file = Storage::disk('public')->path('/src/m3u8');
        $dest = Storage::disk('streaming')->path( $video->id .'/m3u8');
        File::copyDirectory($file,$dest);

        // copy thumbnails
        //$file = Storage::disk('streaming')->path('1/thumbnails');
        $image =  rand(1, 20) . '.jpg';
        $file = Storage::disk('public')->path('/src/posters/' .  $image);
        $dest = Storage::disk('streaming')->path( $video->id . '/thumbnails/potrait.jpg');
        File::copy($file,$dest);

        $file = Storage::disk('public')->path('/src/posters/landscape.jpg');
        $dest = Storage::disk('streaming')->path( $video->id . '/thumbnails/poster.jpg');
        File::copy($file,$dest);

        // copy secret keys
        //$file = Storage::disk('assets')->path('1/secrets');
        $file = Storage::disk('public')->path('/src/secrets');
        $dest = Storage::disk('assets')->path( $video->id . '/secrets');
        File::copyDirectory($file,$dest);

       }
    }
}
