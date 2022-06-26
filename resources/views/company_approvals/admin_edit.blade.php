
@extends('layouts.master')

@section('title', 'Update Company Detail')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('company-approvals.index') }}">{{ __('Company Approvals') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Company Approval</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST"  action="{{ route('company-approvals.admin_update', $companyApproval->id) }}" >
@csrf
@method('PUT')


<div class="card card-secondary col-">
    <div class="card-header">
      <strong>Profile</strong>
    </div>
    <div class="card-body">

        <dl class="row">
            <dt class="col-sm-2">Name</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->name  }}</dd>

            <dt class="col-sm-2">Email</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->email  }}</dd>

            <dt class="col-sm-2">Phone</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->phone  }}</dd>

            <dt class="col-sm-2">Address</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->address  }}</dd>

            <dt class="col-sm-2">Postcode</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->postcode  }}</dd>

            <dt class="col-sm-2">City</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->city  }}</dd>

            <dt class="col-sm-2">State</dt>
            <dd class="col-sm-9">{{ $companyApproval->company->states   }}</dd>
        </dl>
    </div>
  </div>


<div class="card card-dark">
    <div class="card-header clearfix">

        <h3 class="card-title">Update Content Detail</h3>

    </div><!-- /.card-header -->

    <div class="card-body">
        @include('company_approvals.admin_form')
    </div><!-- /.card-body -->

</div><!-- /.card -->
</form>
@stop
