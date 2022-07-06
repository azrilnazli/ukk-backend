@extends('layouts.master')

@section('title', 'Penanda & Urusetia for Pitching Session')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('signers.index') }}">{{ __('Signers Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal Signers</li>
    </ol>
</nav>
@stop

@section('content')
<form id="store_signers" method="post" action="{{ route('pitching-signers.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
  <div class="card bg-secondary">
    <div class="card-body">
        <div class="card-title">
            @include('pitching.signers.partials.header')
        </div>

        <div class="p-3">
            @include('pitching.signers.partials.form')
        </div>

        <div class="card-footer">
            @include('pitching.signers.partials.footer')
        </div>
    </div>
</form>
@stop
