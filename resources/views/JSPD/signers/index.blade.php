
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="route('signers.index')">{{ __('Proposal Signers') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal List</li>
    </ol>
</nav>
@stop

@section('content')
    @include('JSPD.partials.index')
@stop
