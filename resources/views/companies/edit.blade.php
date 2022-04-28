
@extends('layouts.master')

@section('name', 'Update Company')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/companies">{{ __('Company Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" id="edit_Company" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card card-dark">
  
    <div class="card-header">
        <div class="pull-left">
            <h3 class="card-name">Edit Company</h3>
        </div>

    </div><!-- /.card-header -->

    <div class="card-body p-5">
     
          <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $company->name }}" required autocomplete="name" >

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="experiences" class="col-md-4 col-form-label text-md-right">{{ __('Experiences') }}</label>

              <div class="col-md-6">
                  <!--<input id="experiences" type="experiences" class="form-control @error('experiences') is-invalid @enderror" name="experiences" value="{{ old('experiences') }}" required autocomplete="experiences"> -->
                  <textarea class="form-control @error('experiences') is-invalid @enderror" rows="8" id="experiences" name="experiences" style="resize:none" required autocomplete="experiences">{{ $company->experiences }}</textarea>
                  @error('experiences')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="mt-3">
                    <button id="submit" class="btn btn-primary" >Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/companies'">
                        Cancel 
                    </button>
                  </div>
              </div>
              
          </div>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</form>
<script>
    $( document ).ready(function() {
          $( "#submit" ).click(function() {
          //alert( "Handler for .click() called." );
          $("#edit_Company").submit();
        });
    });
    </script>
@stop