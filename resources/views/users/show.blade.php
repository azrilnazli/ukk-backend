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
<form method="POST" action="{{ route('users.store') }}">
@csrf
<!-- Horizontal Form -->
<div class="card card-dark">
    <div class="card-header">
        
        <div class="row ">
            <div class="col-md-4">
                <h4>{{ ucwords($user->name) }}</h4>
            </div>
            <div class="col-md-4" ">
              

            </div>
            <div class="col-md-4 ">
                <div class="row float-right ">
                <a 
                    href="{{ route('users.edit', $user->id) }}"
                    class="btn btn-success"  
                    role="button">
                    <i class="fas fa-edit"></i> {{ __('Update') }}
                 </a>
                    &nbsp;
                <a  class="btn btn-danger"  
                    role="button"
                    onclick="event.preventDefault();
                    document.getElementById('delete-form').submit();">
                     <i class='fas fa-trash'></i>  {{ __('Delete') }}
                 </a>
                </div>
        
            </div>
        </div>


    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                  <th style="width:10%">First Name</th>
                  <th>{{ $user->firstname }} </th>
                </tr>

                <tr>
                    <th style="width:10%">Last Name</th>
                    <th>{{ $user->firstname }} </th>
                  </tr>
                <tr>
                    <th style="width:10%">Email</th>
                    <th>{{ $user->email }} </th>
                </tr>
                <tr>
                    <th style="width:10%">Joined</th>
                    <th>{{ $user->created_at->diffForhumans() }} </th>
                </tr>
                <tr>
                    <th style="width:10%">Roles</th>
                    <th>
                    @foreach( $user->getRoleNames() as $role ) 
                        {{ ucfirst($role) }}
                        @if(count($user->getRoleNames()) > 1 )
                           ,
                        @endif
                    @endForeach
                    </th>
                </tr>
                </tbody>
            </table>
          </div>
        
    </div>
    <!-- /.card-body -->
    




</div>
</form>    

<form id="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
    @csrf 
    @method('DELETE')
</form>
@stop