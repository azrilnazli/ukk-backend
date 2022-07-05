@extends('layouts.master')

@section('title', 'Proposal Signers for Pitching Session')


@section('head')
<link href="/css/video-js.css" rel="stylesheet" />
<link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('signers.index') }}">{{ __('Signers Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal Signers</li>
    </ol>
</nav>
@stop



@section('content')
<form id="store_signers" method="post" action="{{ route('pitching-signers.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
  <div class="card bg-secondary">
    <div class="card-header">
        <div class="card-title">
          Proposal by {{ $tenderSubmission->user->company->name }}
          @include('pitching.partials.modal')
        </div>
        <div class="card-item text-right bg-dark p-2">
          PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
          TENDER : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->tender_detail->title }}</span>
          PROGRAMME :  <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->programme_category }}  - {{ $tenderSubmission->tender->programme_code }}</span>
          CHANNEL : <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->channel }}</span>
        </div>
      </div>


    <div class="card-body bg-light">@include('JSPD.signers.form')</div>

    <div class="card-footer bg-light">

        <button id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('signers.tasks') }}'">
            Cancel
        </button>
        <script>
          $( document ).ready(function() {
                $( "#submit" ).click(function() {
                //alert( "Handler for .click() called." );
                $("#store_signers").submit();
              });
          });
          </script>

    </div>
  </div>

</form>
@stop
