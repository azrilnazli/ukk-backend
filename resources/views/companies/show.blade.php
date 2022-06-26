
@extends('layouts.master')

@section('name', 'Update Company')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/companies">{{ __('Company Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show Company</li>
    </ol>
</nav>
@stop

@section('content')

<nav>
    <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab">INFO</a>
      <a class="nav-item nav-link " id="nav-approval-tab" data-toggle="tab" href="#nav-approval" role="tab">REQUEST FOR APPROVAL</a>
      <a class="nav-item nav-link " id="nav-proposal-tab" data-toggle="tab" href="#nav-proposal" role="tab">PROPOSALS</a>
      <a class="nav-item nav-link " id="nav-comments-tab" data-toggle="tab" href="#nav-comments" role="tab">COMMENTS</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active p-2" id="nav-info" role="tabpanel">
        @include('companies.partials.info')
    </div>

    <div class="tab-pane fade p-2" id="nav-approval" role="tabpanel">
        @include('companies.partials.approvals')
    </div>

    <div class="tab-pane fade p-2" id="nav-proposal" role="tabpanel">
        @include('companies.partials.proposals')
    </div>

    <div class="tab-pane fade p-2" id="nav-comments" role="tabpanel">
        @include('companies.partials.comments')
    </div>


</div>

@stop
