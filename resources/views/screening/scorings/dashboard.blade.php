
@extends('layouts.master')

@section('title', 'Scoring Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Screening') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Scoring Dashboard') }}</li>
    </ol>
  </nav>
@stop


@section('content')
    @include('screening.partials.dashboard')
@stop
