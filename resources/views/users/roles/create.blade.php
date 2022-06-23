@extends('layouts.master')

@section('title', 'Create Role')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('user-roles.index') }}">{{ __('Roles') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
    </ol>
</nav>
@stop


@section('content')


<form id="create_role" method="POST" action="{{ route('user-roles.store') }}">
@csrf

<!-- Horizontal Form -->
    <div class="card card-dark">

        <div class="card-header">
            <h3 class="card-title">Create New Role</h3>
        </div><!-- /.card-header -->


        <div class="card-body">
            <div class="form-group row">
                <label for="name" class="col-form-label text-md-right ">{{ __('Name') }} </label>

                <div class="col-lg-4">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="role name"  >

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer">

            <button id="submit" class="btn btn-primary" >Submit</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('user-roles.index') }}'">
                Cancel
            </button>
        </div>
    </div>
</form>


@endsection
