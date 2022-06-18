
@extends('layouts.master')

@section('title', 'Update Tender')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tender-categories.index') }}">{{ __('Tender Category') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Tender Category</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST"  action="{{ route('tender-categories.update', $tenderCategory->id) }}" >
@csrf
@method('PUT')
<div class="card card-dark">

    <div class="card-header clearfix">

        <h3 class="card-title">Update Tender Category</h3>

    </div><!-- /.card-header -->

    <div class="card-body">
        @include('tender_category.form')
    </div><!-- /.card-body -->

</div><!-- /.card -->
</form>
@stop
