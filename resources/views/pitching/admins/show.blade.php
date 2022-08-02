@extends('layouts.master')

@section('title', 'PITCHING - Scoring')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pitching-scorings.index') }}">{{ __('Scoring Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
    </ol>
</nav>
@stop

@section('content')

    <div class="card bg-light">
        <div class="card-title bg-dark rounded">
             @include('pitching.partials.header')
        </div>

        <div class="card-body">
            <nav>
                <div class="nav nav-tabs " id="nav-tab" role="tablist">
                <!-- SIGNERS -->
                @foreach($tenderSubmission->pitching_scorings as $key => $pitchingScoring )
                    <a class="nav-item nav-link text-uppercase @if($key ==0) show active @endif" id="nav-scoring-tab" data-toggle="tab" href="#scoring_{{ $pitchingScoring->id }}" role="tab">[P]-{{ $pitchingScoring->user->name }}</a>
                @endforeach
                <!-- ./SIGNERS -->

                <!-- URUSETIA -->
                @foreach($tenderSubmission->pitching_verifications as $key => $pitchingVerification )
                    <a class="nav-item nav-link text-uppercase id="nav-verification-tab" data-toggle="tab" href="#verification_{{ $pitchingVerification->id }}" role="tab">[U]-{{ $pitchingVerification->user->name }}</a>
                @endforeach
                <!-- ./URUSETIA -->

                <!-- KETUA -->
                @foreach($tenderSubmission->pitching_approvals as $key => $pitchingApproval )
                    <a class="nav-item nav-link text-uppercase id="nav-approval-tab" data-toggle="tab" href="#approval_{{ $pitchingApproval->id }}" role="tab">[K]-{{ $pitchingApproval->user->name }}</a>
                @endforeach
                <!-- ./KETUA -->


                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- SIGNERS -->
                @foreach($tenderSubmission->pitching_scorings as $key => $pitchingScoring )
                    <div  class="tab-pane fade p-2 @if($key ==0) show active @endif" id="scoring_{{ $pitchingScoring->id }}" role="tabpanel">
                        @include('pitching.admins.partials.form', array('pitchingScoring' => $pitchingScoring ) )
                    </div>
                @endforeach
                <!-- ./SIGNERS -->

                <!-- URUSETIA -->
                @foreach($tenderSubmission->pitching_verifications as $key => $pitchingVerification )
                    <div  class="tab-pane fade p-2" id="verification_{{ $pitchingVerification->id }}" role="tabpanel">
                        @include('pitching.admins.partials.form_verification', array('pitchingVerification' => $pitchingVerification ))
                    </div>
                @endforeach
                <!-- ./URUSETIA -->

                <!-- KETUA -->
                @foreach($tenderSubmission->pitching_approvals as $key => $pitchingApproval )
                <div  class="tab-pane fade p-2" id="approval_{{ $pitchingApproval->id }}" role="tabpanel">
                    @include('pitching.admins.partials.form_approval', array('pitchingApproval' => $pitchingApproval ))
                </div>
                @endforeach
                <!-- ./KETUA -->
            </div>
        </div>

        @if($tenderSubmission->pitching_scorings->count() == 3 &&  $tenderSubmission->pitching_urusetias->count() == 1 )

            @if($tenderSubmission->has('pitching_approval'))

            @else
            <form id="store_approval" method="post" action="{{ route('pitching-admins.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
                @csrf
                <div class="card-footer bg-dark">
                    @include('pitching.admins.partials.form_approval')
                </div>

                <div class="card-footer bg-dark">
                    @include('pitching.admins.partials.footer')
                </div>
            </form>
            @endif
        @else
            <div class="card-footer bg-danger">
                <h5><i class="fas fa-exclamation"></i>
                    Penilaian sesi pitching untuk proposal ini masih belum selesai.
                    Sila pastikan semua (3) panel telah selesai membuat penilaian sebelum urusetia dapat melakukan pengesahan.
                </h5>
            </div>
        @endif


    </div>

@include('pitching.partials.modal_acknowledge')

@stop
