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
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>
@stop



@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            title
        </div>    
        <div class="card-item text-right">
            card item
        </div>
    </div>
   
    <div class="card-body">body</div>
    <div class="card-footer">footer</div>
</div>

@stop
