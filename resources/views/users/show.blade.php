@extends('layouts.master')

@section('title', 'Create User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('User Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __(ucfirst($user->name)) }}</li>
    </ol>
</nav>
@stop

@section('content')

<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">User Info</div>
            <div class="card-body">


                {{-- <dl class="row">
                    @foreach($user->toArray() as $key => $value)
                        <dt class="col-sm-4 text-right text-uppercase">{{ str_replace("_", " " , $key) }}</dt>
                        <dd class="col-sm-8 text-left">{{ $value }}</dd>
                    @endforeach
                </dl> --}}
                <dl class="row">
                <dt class="col-sm-4 text-right text-uppercase">user id</dt>
                <dd class="col-sm-8 text-left">{{ $user->id }}</dd>

                <dt class="col-sm-4 text-right text-uppercase">user email</dt>
                <dd class="col-sm-8 text-left">{{ $user->email }}</dd>

                <dt class="col-sm-4 text-right text-uppercase">phone</dt>
                <dd class="col-sm-8 text-left">{{ $user->phone }}</dd>
                </dl>

            </div>
            <div class="card-footer text-muted ">Registered <span>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">Company Info</div>
            <div class="card-body">


                {{-- <dl class="row">
                    @foreach($user->company->toArray() as $key => $value)
                        <dt class="col-sm-4 text-right text-uppercase">{{ str_replace("_", " " , $key) }}</dt>
                        <dd class="col-sm-8 text-left">{!! $value === 1 ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : $value!!}</dd>
                    @endforeach
                </dl> --}}


                <dl class="row">

                        <dt class="col-sm-4 text-right text-uppercase">company id</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->id }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">Is Approved ?</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->is_approved }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company name</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->name }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company email</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->email }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company phone</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->phone }}</dd>

                </dl>
            </div>
            <div class="card-footer text-muted">Submitted <span>{{ \Carbon\Carbon::parse($user->company->created_at)->diffForHumans() }}</div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">Company Info</div>
            <div class="card-body">


             @foreach($user->proposals as $proposal)
                {{$proposal->channel}}
             @endforeach
            </div>
            <div class="card-footer text-muted">Submitted <span>{{ \Carbon\Carbon::parse($user->company->created_at)->diffForHumans() }}</div>
        </div>
    </div>
</div>


<form id="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@stop
