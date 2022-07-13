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
<form id="store_scorings" method="post" action="{{ route('pitching-scorings.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
    <div class="card bg-light">
        <div class="card-title bg-dark rounded">
             @include('pitching.partials.header')
        </div>

        <div class="card-body">
            <nav>
                <div class="nav nav-tabs " id="nav-tab" role="tablist">
                {{-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab">SUMMARY</a> --}}
                @foreach($tenderSubmission->pitching_scorings as $key => $pitchingScoring )
                    <a class="nav-item nav-link text-uppercase @if($key ==0) show active @endif" id="nav-scoring-tab" data-toggle="tab" href="#scoring_{{ $pitchingScoring->id }}" role="tab">{{ $pitchingScoring->user->name }}</a>
                @endforeach

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                {{-- <div class="tab-pane fade show active p-2" id="nav-home" role="tabpanel">
                    @include('JSPD.scorings.summary')
                </div> --}}
                @foreach($tenderSubmission->pitching_scorings as $key => $pitchingScoring )

                <div  class="tab-pane fade p-2 @if($key ==0) show active @endif" id="scoring_{{ $pitchingScoring->id }}" role="tabpanel">
                    @include('pitching.verifications.partials.form', array('pitchingScoring' => $pitchingScoring ) )
                    {{-- {{ $pitchingScoring->id }} --}}
                </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer">
            @include('pitching.partials.footer')
        </div>
    </div>
</form>
@include('pitching.partials.modal_acknowledge')

@stop
