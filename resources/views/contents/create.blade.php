
@extends('layouts.master')

@section('title', 'Create Content')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('contents.index') }}">{{ __('Content Requirement') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Content List</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" action="{{ route('contents.store') }}" >
@csrf
<div class="card card-dark">

    <div class="card-header clearfix">

        <h3 class="card-title">Create Content Detail</h3>

    </div><!-- /.card-header -->

    <div class="card-body">
        @include('contents.form')
    </div><!-- /.card-body -->
</div><!-- /.card -->
</form>

@stop
