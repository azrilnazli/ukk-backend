<?php

return [
    'ffmpeg' => [
        'binaries' => env('FFMPEG_BINARIES', '/usr/bin/ffmpeg'),
        'threads'  => 8, // adjust based on worker PC
    ],

    'ffprobe' => [
        'binaries' => env('FFPROBE_BINARIES', '/usr/bin/ffprobe'),
    ],

    'timeout' => 3600,

    'enable_logging' => true,

    'set_command_and_error_output_on_exception' => false,

    'temporary_files_root' => env('FFMPEG_TEMPORARY_FILES_ROOT', sys_get_temp_dir()),


    /*
        $this->encode('240p',400,426,240);
        $this->encode('360p',700,640,360);
        $this->encode('480p',1100,854,480);
        $this->encode('720p',2500,1280,720);
        $this->encode('1080p',3500,1920,1080);
    */

    'max' => '360p',
    'profiles' => [
        // '240p' => [
        //     'bitrate' => 400,
        //     'width'   => 426,
        //     'height'  => 240
        //     ],
        '360p' => [
            'bitrate' => 700,
            'width'   => 640,
            'height'  => 360
            ],
        // '480p' => [
        //     'bitrate' => 1100,
        //     'width'   => 854,
        //     'height'  => 480
        //     ],
        // '720p' => [
        //     'bitrate' => 2500,
        //     'width'   => 1280,
        //     'height'  => 720
        //     ],
        // '1080p' => [
        //     'bitrate' => 4000,
        //     'width'   => 1920,
        //     'height'  => 1080
        //     ],
    ]
];
