
@extends('layouts.master')

@section('title', 'Profile')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
</nav>
@stop

@section('content')
<div class="card card-dark">
  
    <div class="card-header clearfix">
        <h3 class="card-title">Profile</h3>
    
        <div class="card-tools">
          <a id="submit" class="btn-sm btn-success" href="#" role="button"><i class="fas fa-edit"></i> Update</a>
        </div>
  
    </div><!-- /.card-header -->

    <div class="card-body p-5">
        @include('profile.form')
    </div><!-- /.card-body -->

</div><!-- /.card -->


<script>
$( document ).ready(function() {
      $( "#submit" ).click(function() {
      //alert( "Handler for .click() called." );
      $("#update_profile").submit();
    });
});
</script>
@stop