@extends('layouts.master')

@section('name', 'Dashboard')

@section('content')

<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">User Administration</div>
            <div class="card-body">
                <!-- Registered -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total</span>
                                        <span class="info-box-number">{{ $user['total'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->
                    <!-- Admin -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Admin</span>
                                        <span class="info-box-number">{{ $user['admin'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Admin -->
                    <!-- Subscriber -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Subscriber</span>
                                        <span class="info-box-number">{{ $user['vendor'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Subscriber -->
                    <!-- Comments -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Comments</span>
                                        <span class="info-box-number">{{ $comment['total'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Comments -->
                </div> <!-- ./row -->
            </div>
            <div class="card-footer text-muted ">

            </div>
        </div>
    </div>
</div>
<!-- ./Horizontal Form -->

<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
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
                    <!-- Pending -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Pending</span>
                                        <span class="info-box-number">{{ $company['pending'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Pending -->
                    <!-- Rejected -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Rejected</span>
                                        <span class="info-box-number">{{ $company['rejected'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Rejected -->

                    <!-- Approved -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Approved</span>
                                        <span class="info-box-number">{{ $company['approved'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Approved -->

                    <!-- Resubmit -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Resubmit</span>
                                        <span class="info-box-number">{{ $company['resubmit'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Resubmit -->
                </div> <!-- ./row -->
            </div>
            <div class="card-footer text-muted ">
                <a href="{{ route('companies.is_new') }}" class="btn btn-sm btn-primary">REGISTRATION</a>
                <a href="{{ route('companies.is_pending' ) }}" class="btn btn-sm btn-primary">PENDING</a>
                <a href="{{ route('companies.is_approved') }}" class="btn btn-sm btn-primary">APPROVED</a>
                <a href="{{ route('companies.is_rejected') }}" class="btn btn-sm btn-primary">REJECTED</a>
                <a href="{{ route('companies.is_resubmit') }}" class="btn btn-sm btn-primary">RESUBMIT</a></h5>
            </div>
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
<!-- ./Horizontal Form -->


<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">Proposal </div>
            <div class="card-body">

                <div class="row">
                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total</span>
                                        <span class="info-box-number">{{ $proposal['total'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->
                    <!-- SAMBUNG SIRI -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">SAMBUNG SIRI</span>
                                        <span class="info-box-number">{{ $proposal['sambung_siri'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ SAMBUNG SIRI -->
                    <!-- SWASTA -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">SWASTA</span>
                                        <span class="info-box-number">{{ $proposal['swasta'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ SWASTA -->
                    <!-- PDF Only -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">

                                <div class="info-box-content">
                                        <span class="info-box-text">PDF</span>
                                        <span class="info-box-number">{{ $proposal['pdf_only'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./PDF Only -->
                    <!-- Video Only -->
                    {{-- <div class="col-md-2">
                        <div class="info-box bg-secondary">

                                <div class="info-box-content">
                                        <span class="info-box-text">Video only</span>
                                        <span class="info-box-number">{{ $proposal['video_only'] }}</span>
                                </div>
                        </div>
                    </div> --}}
                    <!-- ./Video Only -->
                    <!-- Both Only -->
                    {{-- <div class="col-md-2">
                        <div class="info-box bg-secondary">

                                <div class="info-box-content">
                                        <span class="info-box-text">PDF & Video</span>
                                        <span class="info-box-number">{{ $proposal['both'] }}</span>
                                </div>
                        </div>
                    </div> --}}
                    <!-- ./Both Only -->
                </div> <!-- ./row -->
            </div>
            <div class="card-footer text-muted ">
                @foreach($tenders as $tender)
                <button type="button" class="p-1 m-2 btn btn-dark btn-sm">
                <span class="text-uppercase">{{ $tender->programme_code}}</span>
                    @if( $tender->count > 0 )
                    <span class="badge badge-light">{{ $tender->count }}</span>
                    @else
                    <span class="badge badge-danger">{{ $tender->count }}</span>
                    @endif
              </button>
              @endforeach
            </div>
        </div>
    </div>
</div>
<!-- ./Horizontal Form -->


<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
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
            <div class="card-footer text-muted ">

            </div>
        </div>
    </div>
</div>
<!-- ./Horizontal Form -->
@endsection




@section('head')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
@stop

@section('script')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
@stop
