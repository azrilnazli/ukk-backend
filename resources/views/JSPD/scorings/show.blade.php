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
        <li class="breadcrumb-item"><a href="{{ route('scorings.tasks') }}">{{ __('View Proposals') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal Scoring</li>
    </ol>
</nav>
@stop

@section('content')
    <form id="store_scorings" method="post" action="{{ route('scorings.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
    @csrf
    <div class="card bg-light">
        <div class="card-header bg-secondary">
            @include('JSPD.partials.header')
        </div>

        <div class="card-body">
        @include('JSPD.scorings.form')
        </div>

        <div class="card-footer p-5">
        @include('JSPD.partials.footer')
        </div>
    </div>
    </form>
@stop
