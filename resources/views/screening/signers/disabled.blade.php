@extends('layouts.master')

@section('title', 'Penanda & Urusetia for Screening Session')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home')}}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('signers.index') }}">{{ __('Signers Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
    </ol>
</nav>
@stop

@section('content')
<form id="store_signers" method="post" action="{{ route('screening-signers.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
    <div class="card">
        <div class="card-title bg-dark rounded">
             @include('screening.partials.header')
        </div>

        <div class="card-body">
            @include('screening.signers.partials.form_disabled')
        </div>

        <div class="card-footer">
            @include('screening.partials.footer')
        </div>
    </div>
</form>
@stop
