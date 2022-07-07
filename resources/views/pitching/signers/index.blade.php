
@extends('layouts.master')

@section('title', 'Pitching - Assign Penanda To Proposal')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
    </ol>
</nav>
@stop

@section('content')
    @include('pitching.signers.partials.index')
@stop
