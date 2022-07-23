
@extends('layouts.master')

@section('title', 'Pitching Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Pitching') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Pitching Dashboard') }}</li>
    </ol>
  </nav>
@stop

@section('content')

<!-- Horizontal Form -->
<div class="row">
    <div class="col">
    <div class="card card-dark">
        <div class="card-header">Pitching</div>
            <div class="card-body">

                <div class="row">
                    <!-- Total -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">

                                <div class="info-box-content">
                                        <span class="info-box-text">Total Proposals</span>
                                        <span class="info-box-number">{{ $total['approved_proposals'] }}/{{ $total['total_proposals'] }} </span>
                                </div>


                        </div>
                    </div>
                    <!-- ./ Total -->
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ./Horizontal Form -->

@include('pitching.admins.partials.index')

@stop
