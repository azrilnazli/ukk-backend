@extends('layouts.master')

@section('content')

<div class="embed-responsive embed-responsive-1by1">
 <iframe class="embed-responsive-item" src="{{url('/jobs')}}">Your browser isn't compatible</iframe>
</div>
@endsection

@section('content-vjs')
<div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8">
    <video-js id="my_video_1" class="vjs-default-skin vjs-big-play-centered" controls preload="auto" data-setup='{"fluid": true}'>
        <source src="{{ route('assets', ['video' => 23, 'playlist' => 'playlist.m3u8']) }}" type="application/x-mpegURL">
    </video-js>

    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script src="https://unpkg.com/@videojs/http-streaming/dist/videojs-http-streaming.js"></script>

    <script>
        var player = videojs('my_video_1');
    </script>
</div>
@stop



@section('head')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />

@stop

@section('script')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
@stop
