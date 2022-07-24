
@extends('layouts.master')

@section('title', 'Pitching Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Pitching') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Pitching Dashboard') }}</li>
    </ol>
  </nav>
@stop

@section('content')

    @include('pitching.admins.partials.dashboard')
    @include('pitching.admins.partials.score_guide')
    @include('pitching.admins.partials.index')

@stop
