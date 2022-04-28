@extends('layouts.master')

@section('title', 'Create User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('User Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
    </ol>
</nav>
@stop

@section('content2')
test
@stop

@section('content')


<form id="create_user" method="POST" action="{{ route('users.store') }}">
@csrf

<!-- Horizontal Form -->
    <div class="card card-dark">

        <div class="card-header">
            <h3 class="card-title">Create New User</h3>
            {{-- <div class="card-tools">
                <a id="submit" class="btn-sm btn-primary" href="#" role="button"><i class="fas fa-plus"></i> Create</a>
            </div> --}}
        </div><!-- /.card-header -->



        <div class="card-body">        
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label text-md-right ">{{ __('Role') }} </label>
                    
                    <div class="col-sm-10">
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" >
                            <option value="">Choose a role</option>
                            @foreach($roles as $key => $name)
                                <option  @if( old('role') == $name) {{ 'selected' }}  @endif value="{{ $name }}">{{ ucfirst($name) }}</option>
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
                    <label for="name" class="col-sm-2 col-form-label text-md-right ">{{ __('Name') }} </label>
    
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="User Fullname" autofocus >
    
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label text-md-right ">{{ __('E-Mail') }} </label>
    
                    <div class="col-sm-10">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="User E-Mail">
    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label text-md-right">{{ __('Password') }}</label>
    
                    <div class="col-sm-10">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter a strong password">
    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="password-confirm" class="col-sm-2 col-form-label text-md-right">{{ __('Confirm') }}</label>
    
                    <div class="col-sm-10">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Comfirn your password">
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
</div>

<script>
    $( document ).ready(function() {
          $( "#submit" ).click(function() {
          //alert( "Handler for .click() called." );
          $("#create_user").submit();
        });
    });
    </script>


@stop