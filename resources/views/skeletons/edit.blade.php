@extends('layouts.master')

@section('title', 'Update Role')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('Users') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Update Role') }}</li>
    </ol>
</nav>
@stop

@section('content')
<form id="update_role" method="POST" action="{{ route('roles.update', $role->name) }}">
    @csrf
    @method('PUT')
    <!-- Horizontal Form -->
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Update existing role</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        card body
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        card footer
        </div>
        <!-- /.card-footer -->
    </div>
</form>   

<script>
    $( document ).ready(function() {
          $( "#submit" ).click(function() {
          //alert( "Handler for .click() called." );
          $("#update_role").submit();
        });
    });
</script>
@stop