@extends('layouts.master')

@section('title', 'Video List')

@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />

@stop


@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Video Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show Video</li>
    </ol>
</nav>
@stop




@section('content')
<div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8">

    <video-js id="my_video_1" class="vjs-default-skin vjs-big-play-centered" controls preload="auto" 
    data-setup='{
      "fluid": true,
      "poster": "{{ Storage::disk('streaming')->url( $video->id . '/thumbnails/poster.jpg')}}" 
    }'>
          <source src=" {{ route('assets', ['video' => $video->id, 'playlist' => 'playlist.m3u8']) }} " type="application/x-mpegURL">
         
    </video-js>

    <script src="/js/videojs/video.js"></script>
    <script src="/js/videojs//videojs-http-streaming.js"></script>
    <script src="/js/videojs/videojs-contrib-quality-levels.js"></script>
    <script src="/js/videojs/videojs-hls-quality-selector.min.js"></script>

    <script>
        var player = videojs('my_video_1');
        player.hlsQualitySelector();
    </script>

</div>

<div class="row mt-4">
    <div class=" col-12">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><label class="badge badge-warning p-2 text-uppercase ">{{$video->user->company->id}}</label> Proposal by {{ $video->user->company->name }} </h3>
      </div>

      <!-- /.card-body -->
      <div class="card-footer">

        Created at : <strong>{{ $video->created_at }}</strong> around {{ $video->created_at->diffForHumans() }}
        <br />
        Updated at : <strong>{{ $video->updated_at }}</strong> around {{ $video->updated_at->diffForHumans() }}
        <br />
        Playback URL  : <strong>{{ route('assets', ['video' => $video->id, 'playlist' => 'playlist.m3u8']) }}</strong>
      </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


<div class="row mt-4">
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fas fa-hourglass"></i></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Video Duration</span>
        <span class="info-box-number">{{ \Carbon\CarbonInterval::seconds($video->duration)->cascade()->forHumans() }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-success"><i class="fas fa-database"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Filename : <strong>{{ $video->original_filename }}</strong>
        
        <span class="info-box-text">Size : <strong>{{ round($video->filesize/1000000) }} MB</strong></span>
       </span>
      </div>


      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->



  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-warning"><i class="fas fa-cog"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Processing Time</span>
        <span class="info-box-number">{{ \Carbon\CarbonInterval::seconds($video->processing_duration)->cascade()->forHumans() }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-danger"><i class="fas fa-video"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Original Resolution</span>
        <span class="info-box-number">{{$video->width}}x {{$video->height}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


  
<div class="row mt-4">
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fas fa-upload"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Upload Duration</span>
        <span class="info-box-number">{{ \Carbon\CarbonInterval::seconds($video->uploading_duration)->cascade()->forHumans() }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-success"><i class="fas fa-tachometer-alt"></i></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Upload Speed</span>
        <span class="info-box-number">
        @if($video->uploading_duration > 0 )
        {{   round((($video->filesize*8)/$video->uploading_duration)/1000000)   }} Mbps
        @endif
         </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-warning"><i class="fas fa-info"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Original Codec</span>
        <span class="info-box-number"><small>{{ $extra['format'] }}</small></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-danger"><i class="fas fa-info"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Original Bitrate</span>
        <span class="info-box-number">{{ round($video->bitrate/1000000)   }} Mbps</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
<!-- /.row -->

<div class="row mt-4">

  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fas fa-database"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Asset Size ( HLS )</span>
        <span class="info-box-number">{{ $video->asset_size }} MB</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fas fa-video"></i></span>
  
        <div class="info-box-content">
          <span class="info-box-text">Codec</span>
          <span class="info-box-number">H264/AAC</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-key"></i></span>
      
            <div class="info-box-content">
              <span class="info-box-text">Encryption</span>
              <span class="info-box-number"><small>AES Rotating keys</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-info"></i></span>
              
                    <div class="info-box-content">
                      <span class="info-box-text">Stream Type</span>
                      <span class="info-box-number"><small>5 MBR streaming</small></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
  
</div>
<!-- /.row -->
@stop