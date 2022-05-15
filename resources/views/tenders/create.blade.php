
@extends('layouts.master')

@section('title', 'Create Tender')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tenders">{{ __('Tender Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tender List</li>
    </ol>
</nav>
@stop

@section('content')
<form method="POST" action="{{ route('tenders.store') }}" >
@csrf
<div class="card card-dark">
  
    <div class="card-header clearfix">

        <h3 class="card-title">Create Tender</h3>
    
 
    </div><!-- /.card-header -->

    <div class="card-body p-5">

        <div class="form-group row">
            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tender Type') }}</label>

            <div class="col-md-6">
                <select  name="type" class="form-control @error('type') is-invalid @enderror">
                    <option value="0">Choose type </option>
                    <option disabled>--------------------</option>
                    @foreach($types as $key => $type)
                    <option 
                    @if ($type == old('type', isset($tender->type) ? $tender->type : null )) selected="selected" @endif
                    value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
                @error('channel')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
     
        <div class="form-group row">
            <label for="classification" class="col-md-4 col-form-label text-md-right">{{ __('TV Channel') }}</label>

            <div class="col-md-6">
                <select  name="channel" class="form-control @error('channel') is-invalid @enderror">
                    <option value="0">Choose channel </option>
                    <option disabled>--------------------</option>
                    @foreach($channels as $key => $channel)
                    <option 
                    @if ($channel == old('channel', isset($tender->channel) ? $video->channel : null )) selected="selected" @endif
                    value="{{$channel}}">{{$channel}}</option>
                    @endforeach
                </select>
                @error('channel')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="classification" class="col-md-4 col-form-label text-md-right">{{ __('Language') }}</label>

            <div class="col-md-6">
                <select  name="language" class="form-control @error('language') is-invalid @enderror">
                    <option value="0">Choose Language </option>
                    <option disabled>--------------------</option>
                    @foreach($languages as $key => $language)
                    <option 
                    @if ($language == old('language', isset($tender->language) ? $video->language : null )) selected="selected" @endif
                    value="{{$language}}">{{$language}}</option>
                    @endforeach
                </select>
                @error('language')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="programme_code" class="col-md-4 col-form-label text-md-right">{{ __('Programme Code') }}</label>

            <div class="col-md-6">
                <input id="programme_code" type="text" class="form-control @error('programme_code') is-invalid @enderror" name="programme_code" value="{{ old('programme_code') }}" required  >

                @error('programme_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="number_of_episode" class="col-md-4 col-form-label text-md-right">{{ __('Number of Episode') }}</label>

            <div class="col-md-1">
                <input id="number_of_episode" type="text" class="form-control @error('number_of_episode') is-invalid @enderror" name="number_of_episode" value="{{ old('number_of_episode') }}" required  >

                @error('number_of_episode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 
        </div>

        <div class="form-group row">
            <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Duration per Episode') }}</label>

            <div class="col-md-1">
                <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') }}" required  >

                @error('duration')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="tender_category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

            <div class="col-md-6">
                <input id="tender_category" type="text" class="form-control @error('tender_category') is-invalid @enderror" name="tender_category" value="{{ old('tender_category') }}" required >

                @error('tender_category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
{{-- 
        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

            <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required >

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div> --}}

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
                <button type="button" class="btn btn-secondary" onclick="window.location.href='/tenders'">
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
      $("#create_Tender").submit();
    });
});
</script>
@stop