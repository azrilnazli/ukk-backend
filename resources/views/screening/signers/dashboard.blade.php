
@extends('layouts.master')

@section('title', 'Screening Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Screening') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Signer Dashboard') }}</li>
    </ol>
  </nav>
@stop

@section('content')
    @include('screening.partials.dashboard')
@stop
