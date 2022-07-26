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
<form id="store_scorings" method="post" action="{{ route('screening-scorings.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
    <div class="card bg-light">
        <div class="card-title bg-dark rounded">
             @include('screening.partials.header')
        </div>

        <div class="card-body">
            @include('screening.scorings.partials.form')
        </div>

        <div class="card-footer">
            @include('screening.scorings.partials.footer')
        </div>
    </div>
</form>
@include('screening.partials.modal_acknowledge')

@stop
