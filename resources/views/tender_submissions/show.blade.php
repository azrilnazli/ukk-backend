@extends('layouts.master')

@section('title', 'Proposal List')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />

@stop


@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tender_submissions">{{ __('View Proposals') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show Proposal</li>
    </ol>
</nav>
@stop

@section('content')
    @include('tender_submissions.partials.show')
@stop
