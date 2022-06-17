
@extends('layouts.master')

@section('title', 'Create Tender')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tender-details.index') }}">{{ __('Tender Detail') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tender Detail List</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" action="{{ route('tender-details.store') }}" >
@csrf
<div class="card card-dark">

    <div class="card-header clearfix">

        <h3 class="card-title">Create Tender Detail</h3>

    </div><!-- /.card-header -->

    <div class="card-body">
        @include('tender_details.form')
    </div><!-- /.card-body -->
</div><!-- /.card -->
</form>

@stop
