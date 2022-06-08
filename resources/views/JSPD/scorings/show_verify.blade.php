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
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">PENANDA 1</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">PENANDA 2</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">PENANDA 3</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">test 1</div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">test 2</div>
          <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">test 3</div>
        </div>

      </div>

      <div class="card-footer bg-info ">
        @include('JSPD.scorings.footer')
      </div>

    </div>
  </form>
@stop
