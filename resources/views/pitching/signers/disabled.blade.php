@extends('layouts.master')

@section('title', 'Proposal Signers')

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
<form id="store_signers" method="post" action="{{ route('signers.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
  <div class="card bg-secondary">
    <div class="card-header">
        <div class="card-title">
          Proposal by {{ $tenderSubmission->user->company->name }}
          @include('JSPD.scorings.modal_tender_submission')
        </div>
        <div class="card-item text-right">
          <span class="badge badge-warning text-uppercase">PROPOSAL ID</span> : {{ $tenderSubmission->id}}
          <span class="badge badge-warning text-uppercase ">CATEGORY</span> : {{ $tenderSubmission->tender->type }} - {{ $tenderSubmission->tender->programme_category }}
          <span class="badge badge-warning text-uppercase ">CODE</span> : {{ $tenderSubmission->tender->programme_code }}
          <span class="badge badge-warning text-uppercase ">CHANNEL</span> : {{ $tenderSubmission->tender->channel }}
        </div>
      </div>


    <div class="card-body bg-light">@include('JSPD.signers.form_disabled')</div>
    <div class="card-footer bg-light">

        <button disabled id="submit" class="btn btn-primary" >Submit</button>
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
