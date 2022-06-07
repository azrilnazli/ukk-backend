@extends('layouts.master')

@section('title', 'Update User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('User Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Update') }}</li>
    </ol>
</nav>
@stop

@section('content')
<form id="update_user" method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')
<!-- Horizontal Form -->
<div class="card card-dark">
    <div class="card-header">
      <h3 class="card-title">Update existing user</h3>
      {{-- <div class="card-tools">
        <a id="submit" class="btn-sm btn-success" href="#" role="button"><i class="fas fa-edit"></i> Update</a>
      </div> --}}
    </div>
    <!-- /.card-header -->



        <div class="card-body">
       
    
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Role') }} </label>
                    <div class="col-sm-10">
                        @php
                        $current_role = $user->getRoleNames()->first();
                        @endphp
                        
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" >
                            @foreach($roles as $role)
                                <option  @if( old('role') == $role || $current_role == $role ) {{ 'selected' }}  @endif  value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endForeach
                        </select>
                       
                                                    
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Name') }} </label>
    
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user['name'] ?$user['name'] : old('name')   }}" required autocomplete="name" autofocus>
    
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="occupation" class="col-sm-2 col-form-label text-md-right">{{ __('Occupation') }} </label>
    
                    <div class="col-sm-10">
                        <input id="occupation" type="occupation" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ $user['occupation'] ?  $user['occupation'] : old('occupation')  }}" required autocomplete="email">
    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

    
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label text-md-right">{{ __('E-Mail Address') }} </label>
    
                    <div class="col-sm-10">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user['email'] ?  $user['email'] : old('email')  }}" required autocomplete="email">
    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label text-md-right">{{ __('Reset Password') }}</label>

                    <div class="col-sm-10">
                        <input id="password"  type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="mt-3">
                            <button id="submit" class="btn btn-primary" >Submit</button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='/users'">
                                Cancel 
                            </button>
                          </div>
                    </div>
                </div>
            </div>
        </div>
</form>    
<script>
    $( document ).ready(function() {
          $( "#submit" ).click(function() {
          //alert( "Handler for .click() called." );
          $("#update_user").submit();
        });
    });
    </script>
@stop