
@extends('layouts.master')

@section('title', 'Update Tender')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tenders">{{ __('Tender Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Tender</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" id="edit_Tender" action="{{ route('tenders.update', $tender->id) }}" >
@csrf
@method('PUT')
<div class="card card-dark">

    <div class="card-header">
        <div class="pull-left">
            <h3 class="card-title">Edit Tender</h3>
        </div>
        {{-- <div class="card-tools">
            <a id="submit" class="btn-sm btn-success" href="#" role="button"><i class="fas fa-edit"></i> Update</a>
        </div> --}}

    </div><!-- /.card-header -->

    <div class="card-body p-5">
        @include('tenders.form')
    </div><!-- /.card-body -->
</div><!-- /.card -->
</form>

@stop
