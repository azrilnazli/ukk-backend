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
          <li class="breadcrumb-item"><a href="{{ route('scorings.index') }}">{{ __('View Proposals') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Proposal Scoring</li>
      </ol>
  </nav>
@stop

@section('content')
  <form id="store_scorings" method="post" action="{{ route('scorings.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
  @csrf
    <div class="card">
      <div class="card-header bg-secondary">
        @include('JSPD.scorings.header')
      </div>
    
      <div class="card-body">
        {{-- @include('JSPD.scorings.form_verify') --}}

        

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab">SUMMARY</a>
            @foreach($scorings as $key => $score )
              <a class="nav-item nav-link text-uppercase" id="nav-scoring-tab" data-toggle="tab" href="#score_{{ $score->id }}" role="tab">{{ optional($score)->user->name }}</a>
            @endforeach

          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active p-2" id="nav-home" role="tabpanel">test 1</div>
          @foreach($scorings as $key => $score )
            <div class="tab-pane fade p-2" id="score_{{ $score->id }}" role="tabpanel">
              @include('JSPD.scorings.form_verify', ['data' => $score])
            </div>
          @endforeach
  
        </div>

      </div>

      <div class="card-footer bg-info ">
        @include('JSPD.scorings.footer')
      </div>

    </div>
  </form>
@stop
