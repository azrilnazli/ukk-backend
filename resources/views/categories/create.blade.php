
@extends('layouts.master')

@section('title', 'Create Category')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/categories">{{ __('Category Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Video List</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" id="create_category" action="{{ route('categories.store') }}" enctype="multipart/form-data">
@csrf
<div class="card card-dark">
  
    <div class="card-header clearfix">

        <h3 class="card-title">Create Category</h3>
    
        {{-- <div class="card-tools">
          <a id="submit" class="btn-sm btn-primary" href="#" role="button"><i class="fas fa-plus"></i> Create</a>
        </div> --}}
  
    </div><!-- /.card-header -->

    <div class="card-body p-5">
     
          <div class="form-group row">
              <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

              <div class="col-md-6">
                  <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" >

                  @error('title')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

              <div class="col-md-6">
                  <!--<input id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description"> -->
                  <textarea class="form-control @error('description') is-invalid @enderror" rows="8" id="description" name="description" style="resize:none" required autocomplete="description">{{ old('description') }}</textarea>
                  @error('description')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="mt-3">
                    <button id="submit" class="btn btn-primary" >Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/categories'">
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
      $("#create_category").submit();
    });
});
</script>
@stop