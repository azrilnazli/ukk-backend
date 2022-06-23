@extends('layouts.master')

@section('name', 'Dashboard')

@section('content')


<!-- Horizontal Form -->
    <div class="row">
        <div class="col">
        <div class="card card-dark">
            <div class="card-header">Registered Company </div>
            <div class="card-body">
                <!-- Total -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total</span>
                                        <span class="info-box-number">{{ $company['total'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Total -->
                    <div class="card-footer text-muted ">

                        @foreach($states as $state)
                            <button type="button" class="p-1 m-2 btn btn-dark btn-sm">
                            <span class="text-uppercase">{{ $state->states}}</span> <span class="badge badge-light">{{ $state->count }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./Horizontal Form -->


<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-dark">
            <div class="card-header">Video </div>
            <div class="card-body">

                <div class="row">
                    <!-- Total -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total</span>
                                        <span class="info-box-number">{{ $video['total'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Total -->
                    <!-- filezie -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Uploaded Size</span>
                                        <span class="info-box-number">{{ number_format( round($video['filesize'] / 1048576,2))  }} MB</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ filezie -->
                    <!-- Asset Size -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Processed Size</span>
                                        <span class="info-box-number">{{ number_format(round($video['asset_size'])) }} MB</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Asset Size -->
                    <!-- Duration -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total Duration</span>
                                        <span class="info-box-number">{{ number_format(round($video['duration']/60)) }} minutes</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Duration -->
                    <!-- Playback -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total Playback</span>
                                        <span class="info-box-number">{{ number_format(round($video['playback']/60)) }} minutes</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Playback -->
                    <!-- Cloud Processing -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Cloud Processing</span>
                                        <span class="info-box-number">{{ number_format(round($video['processing']/60)) }} minutes</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Cloud Processing -->

                </div> <!-- ./row -->
            </div>

        </div>
    </div>
</div>

@endsection




@section('head')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
@stop

@section('script')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
@stop
