
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="route('pitching-signers.tasks')">{{ __('Proposal Signers') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Tasks</li>
    </ol>
</nav>
@stop

@section('content')
    @include('pitching.signers.partials.index')
@stop
