@extends('layouts.master')

@section('title', 'SCREENING - Scoring')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('screening-scorings.index') }}">{{ __('Scoring Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
    </ol>
</nav>
@stop

@section('content')

    <div class="card bg-light">
        <div class="card-title bg-dark rounded">
             @include('screening.partials.header')
        </div>

        <div class="card-body">
            <nav>
                <div class="nav nav-tabs " id="nav-tab" role="tablist">
                <!-- SIGNERS -->
                @foreach($tenderSubmission->screening_scorings as $key => $screeningScoring )
                    <a class="nav-item nav-link text-uppercase @if($key ==0) show active @endif" id="nav-scoring-tab" data-toggle="tab" href="#scoring_{{ $screeningScoring->id }}" role="tab"><small>[P]-{{ $screeningScoring->user->name }}</small></a>
                @endforeach
                <!-- ./SIGNERS -->

                <!-- URUSETIA -->
                @foreach($tenderSubmission->screening_verifications as $key => $screeningVerification )
                    <a class="nav-item nav-link text-uppercase id="nav-verification-tab" data-toggle="tab" href="#verification_{{ $screeningVerification->id }}" role="tab"><small>[U]-{{ $screeningVerification->user->name }}</small></a>
                @endforeach
                <!-- ./URUSETIA -->

                <!-- KETUA -->
                @foreach($tenderSubmission->screening_approvals as $key => $screeningApproval )
                    <a class="nav-item nav-link text-uppercase id="nav-approval-tab" data-toggle="tab" href="#approval_{{ $screeningApproval->id }}" role="tab"><small>[K]-{{ $screeningApproval->user->name }}</small></a>
                @endforeach
                <!-- ./KETUA -->


                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- SIGNERS -->
                @foreach($tenderSubmission->screening_scorings as $key => $screeningScoring )
                    <div  class="tab-pane fade p-2 @if($key ==0) show active @endif" id="scoring_{{ $screeningScoring->id }}" role="tabpanel">
                        @include('screening.verifications.partials.form', array('screeningScoring' => $screeningScoring ) )
                    </div>
                @endforeach
                <!-- ./SIGNERS -->

                <!-- URUSETIA -->
                @foreach($tenderSubmission->screening_verifications as $key => $screeningVerification )
                    <div  class="tab-pane fade p-2" id="verification_{{ $screeningVerification->id }}" role="tabpanel">
                        @include('screening.admins.partials.form_verification', array('screeningVerification' => $screeningVerification ))
                    </div>
                @endforeach
                <!-- ./URUSETIA -->

                <!-- KETUA -->
                @foreach($tenderSubmission->screening_approvals as $key => $screeningApproval )
                <div  class="tab-pane fade p-2" id="approval_{{ $screeningApproval->id }}" role="tabpanel">
                    @include('screening.admins.partials.form_approval', array('screeningApproval' => $screeningApproval ))
                </div>
                @endforeach
                <!-- ./KETUA -->
            </div>
        </div>

        @if($tenderSubmission->screening_scorings->count() == 3 &&  $tenderSubmission->screening_urusetias->count() == 1 )

            @if($tenderSubmission->screening_approval)

            @else
            <form id="store_approval" method="post" action="{{ route('screening-admins.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
                @csrf
                <div class="card-footer bg-dark">
                    @include('screening.admins.partials.form_approval')
                </div>

                <div class="card-footer bg-dark">
                    @include('screening.admins.partials.footer')
                </div>
            </form>
            @endif
        @else
            <div class="card-footer bg-danger">
                <h5><i class="fas fa-exclamation"></i>
                    Penilaian sesi screening untuk proposal ini masih belum selesai.
                    Sila pastikan semua (3) panel telah selesai membuat penilaian sebelum urusetia dapat melakukan pengesahan.
                </h5>
            </div>
        @endif


    </div>

@include('screening.partials.modal_acknowledge')

@stop
