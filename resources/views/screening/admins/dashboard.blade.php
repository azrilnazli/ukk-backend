
@extends('layouts.master')

@section('title', 'Screening Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Screening') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Screening Dashboard') }}</li>
    </ol>
  </nav>
@stop

@section('content')

    @include('screening.admins.partials.dashboard')
    @include('screening.admins.partials.score_guide')
    @include('screening.admins.partials.index')

@stop
