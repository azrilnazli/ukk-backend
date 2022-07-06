@extends('layouts.master')

@section('title', 'Scoring for Pitching Session')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('scorings.index') }}">{{ __('Scoring Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal Scorings</li>
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
            @include('pitching.scorings.partials.form')
        </div>

        <div class="card-footer">
            @include('pitching.partials.footer')
        </div>

    </div>
</form>

@stop
