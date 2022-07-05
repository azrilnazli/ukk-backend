@extends('layouts.master')
@section('title', 'Scoring Proposal List')

@section('head')
  <link href="/css/video-js.css" rel="stylesheet" />
  <link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('scorings.tasks') }}">{{ __('Tasks') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Proposal Verification</li>
      </ol>
  </nav>
@stop

@section('content')

  <div class="card">
      <div class="card-header bg-secondary">
        @include('JSPD.scorings.header')
      </div>

      <div class="card-body">
         @include('JSPD.scorings.contents')
      </div>



    <div class="row">


            @if( count($tenderSubmission->verifications) == 0)

                <div class="col m-1 p-2 bg-dark rounded">@include('JSPD.scorings.urusetia-form')</div>

            @elseif(  count($tenderSubmission->verifications) == 1  )

                @if( !$tenderSubmission->verifications->pluck('user_id')->contains( auth()->user()->id ))
                    <div class="col m-1 p-2 bg-dark rounded">@include('JSPD.scorings.urusetia-form')</div>
                @endif


                @foreach($tenderSubmission->verifications as $verification)
                <div class="col m-1 p-2 bg-dark rounded">@include('JSPD.scorings.urusetia-1')</div>
                @endforeach


            @elseif(  count($tenderSubmission->verifications) == 2 )
                @foreach($tenderSubmission->verifications as $verification)
                    <div class="col m-1 p-2 bg-dark rounded">@include('JSPD.scorings.urusetia-1')</div>
                @endforeach
            @endif

    </div>

  </div>

@stop
