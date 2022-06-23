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
          <li class="breadcrumb-item"><a href="{{ route('jspd-admins.index') }}">{{ __('Proposals') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Proposal Scoring</li>
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

      <div class="card-footer">
        <div class="row">
        @foreach($tenderSubmission->verifications as $verification)
            <div class="col m-1 p-2 bg-info rounded">@include('JSPD.admins.urusetia-1')</div>
        @endforeach
        </div>
        <div class="row">
            <div class="col m-1 p-2 bg-light rounded">@include('JSPD.admins.ketua-urusetia')</div>
        </div>

      </div>

    </div>

@stop
