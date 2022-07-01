@extends('layouts.master')

@section('title', 'tenderSubmission List')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />

@stop


@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tender_submissions">{{ __('View Proposals') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show Proposal</li>
    </ol>
</nav>
@stop




@section('content')
<div class="row mt-4">
    <div class=" col-12">
    <div class="card card-dark">
      <div class="card-header">
        <div class="card-title">
          <label class="badge badge-warning p-2 text-uppercase ">
            {{$tenderSubmission->company->id}}</label> Proposal by {{ $tenderSubmission->company->name }}
          </div>

      </div>
      <div class="card-body bg-secondary">
        <span class="badge badge-info text-uppercase ">TENDER</span> : {{ $tenderSubmission->tender->tender_detail->title }}
        <span class="badge badge-info text-uppercase ">CODE</span> : {{ $tenderSubmission->tender->programme_category }} - {{ $tenderSubmission->tender->programme_code }}
        <span class="badge badge-info text-uppercase ">CHANNEL</span> : {{ $tenderSubmission->tender->channel }}

      </div>

      @foreach($fields as $field)
      <div class="card-body">
        <span class="badge badge-dark text-uppercase">{{ str_replace('_',' ',$field)}}</span>
        <div class="alert alert-light">
        <span class="lead">{{ $tenderSubmission->$field }}</span>
        </div>
      </div>
      <hr />
      @endforeach


      @if($tenderSubmission->video)
        @if($tenderSubmission->video->is_ready)

        <div class="card-body">
            <span class="badge badge-dark">Video</span>

                <div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8">

                    <video-js id="my_video_1" class="vjs-default-skin vjs-big-play-centered" controls preload="auto"
                    data-setup='{
                    "fluid": true,
                    "poster": "{{ Storage::disk('streaming')->url($tenderSubmission->video->id . '/thumbnails/poster.jpg')}}"
                    }'>
                        <source src=" {{ route('assets', ['video' =>$tenderSubmission->video->id, 'playlist' => 'playlist.m3u8']) }} " type="application/x-mpegURL">

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
        </div>
        <hr />
        @endif
      @endif

      @if($tenderSubmission->is_pdf_cert_uploaded)
      <div class="card-body">
        <span class="badge badge-dark">PDF</span>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <div style="height:500px" id="document"></div>
        <script>PDFObject.embed("/storage/proposals/{{$tenderSubmission->id}}/proposal.pdf", "#document");</script>
      </div>

      @endif
      <!-- /.card-body -->
      <div class="card-footer">

        Created at : <strong>{{ $tenderSubmission->created_at }}</strong> around {{ $tenderSubmission->created_at->diffForHumans() }}
        <br />
        Updated at : <strong>{{ $tenderSubmission->updated_at }}</strong> around {{ $tenderSubmission->updated_at->diffForHumans() }}
       </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@stop
