
@extends('layouts.master')

@section('title', 'Pitching Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Pitching') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Signer Dashboard') }}</li>
    </ol>
  </nav>
@stop

@section('content')
    @include('pitching.partials.dashboard')
@stop
