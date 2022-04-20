@extends('layouts.master')

@section('title', 'Video List')

@section('head')
<link href="/css/video-js.css" rel="stylesheet" />

@stop

@section('script')
<script src="/js/videojs/video.js"></script>
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Video Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Encoding Status</li>
    </ol>
</nav>
@stop

@section('content')



<!-- Horizontal Form -->
<div class="card card-dark">

  <div class="card-header">
  <h3 class="card-title">Encoding in progress</h3>
  <div class="card-tools">
      <button type="submit" id="create" class="btn-sm btn-dark disabled">
        <i class="fa fa-cog fa-lg fa-spin"></i>
      </button>
  </div>
  </div>
  <!-- /.card-header -->

  @foreach($profiles as $key => $item)
    <!-- {{$key}} start -->
    <div class="card-body">

      <div class="row">

        <div class="col-sm-1">
          <div class="input-group-prepend">
            <button style="height: 40px;" type="button" class="btn btn-danger">{{$key}}</button>
          </div>
        </div>

        <div class="col-sm-10">
            <div class="progress" style="height: 40px;">
              <div id="progressBar_{{$key}}" class="progress-bar" role="progressbar"></div>
            </div>
        </div>

        <div class="col-sm-1">
          <div class="input-group-prepend">
            <button style="height: 40px;" type="button" class="btn btn-dark"><small><span id="status_{{$key}}">0</span> %</small></button>
          </div>
        </div>

      </div><!-- ./row -->
    </div><!-- ./card-body -->
  @endforeach

</div><!-- ./card -->

<script type="text/javascript" src="/js/jquery/1.9.1/jquery.min.js"></script>

<script>
$(document).ready(function () {
  
    var interval = 1500;   //number of mili seconds between each call
    var refresh = function() {
        $.ajax({
            url: "{{ route('videos.progress', $video->id ) }}",
            cache: false,

            success: function(data) {
            //alert(data.message);

              // because this is server side success/error logic
              // have to check data.sucess flag status 

              if(data.success == true){ 

                @foreach($profiles as $key => $item)
                  $('#status_{{ $key }}').html(data.progress_{{ $key }});
                  $('#progressBar_{{ $key }}').css('width', data.progress_{{ $key }}+'%');
                @endforeach

                setTimeout(function() {
                    // find max resolution & redirect
              
                    if(data.progress_{{ $quality['max'] }} < 100) {
                      refresh();
                    } else {
                      // redirect to view page
                      window.location.href = "{{ route('videos.delayed_redirect', $video->id ) }}";
                    }
                }, interval);

              } else {
                 // data.success == FALSE
                 window.location.href = "{{ route('videos.delayed_redirect', $video->id ) }}";
              }

            }, // XHR success

            error: function(){
              // this is for XHR error only
            }

        });
    };
    refresh();
});
</script> 


@stop