
@extends('layouts.master')

@section('title', 'Create Tender')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tenders">{{ __('Tender Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tender List</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" action="{{ route('tenders.store') }}" >
@csrf
<div class="card card-dark">

    <div class="card-header clearfix">
        <h3 class="card-title">Create Tender</h3>
    </div><!-- /.card-header -->

    <div class="card-body p-5">
        @include('tenders.form')
    </div><!-- /.card-body -->
</div><!-- /.card -->
</form>


@stop
