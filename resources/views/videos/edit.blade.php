@extends('layouts.master')

@section('title', 'Update Video')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Video Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Update') }}</li>
    </ol>
</nav>
@stop

@section('content')
<form id="update_video" method="POST" action="{{ route('videos.update', $video->id) }}" enctype="multipart/form-data">

<input type="hidden" name="redirects_to" value="{{ URL::previous() }}" />
@csrf
@method('PUT')

<!-- Horizontal Form -->
<div class="card card-dark">
    <div class="card-header">
      <h3 class="card-title">Update existing video</h3>
      {{-- <div class="card-tools">
        <a id="submit" class="btn-sm btn-success" href="#" role="button"><i class="fas fa-edit"></i> Update</a>
      </div> --}}
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <div class="form-group row" id="title">
                <label for="name" class="col-sm-2 col-form-label text-md-right text-uppercase">{{ __('Title') }}</label>

                <div class="col-8">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter ..." name="title" value="{{ $video->title }}" autofocus>

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row" id="synopsis">
                <label for="name" class="col-sm-2 col-form-label text-md-right text-uppercase">{{ __('Synopsis') }}</label>

                <div class="col-8">
                    <textarea  required autocomplete="synopsis" autofocus name="synopsis" class="form-control @error('synopsis') is-invalid @enderror" rows="3" placeholder="Enter ...">{{ $video->synopsis }}</textarea>
                    @error('synopsis')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label text-md-right text-uppercase ">{{ __('Category') }}</label>
                <div class="col-2">

                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" >
                        @foreach($categories as $key => $category)
                            <option  @if( $video->category_id == $key) {{ 'selected' }}  @endif value="{{ $key }}">{{ $category }}</option>
                        @endForeach
                    </select>
                    @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                    
                    
                </div>
            </div>

            <div class="row mt-5 mb-5">
                <div class="col-2 ">
                </div>
                <div class="col-2 bg-light border border-grey rounded">
                    <div class="ml-10px px-1 py-3">
                        
                        <div style="height:340px" class="col text-center ">
                            <div class="vstack gap-3">
                                <div  style="height:300px">
                        
                                <img id="preview-1" class="mt-2 rounded" 
                                src="{{ isset($poster[1]) ? $poster[1] : '/images/9_16.png' }}" />
                                </div>
                                <div class="">

                                    <div class="input-group">
                                        <div class="custom-file">
                                          <input @error('poster-1') is-invalid @enderror id="poster-1" name="poster-1" type="file" class="custom-file-input">
                                          <label class="custom-file-label  text-md-left" for="poster-1">9x16</label>
                                        </div>
                           
                                    </div>
                                </div>
                   
                              </div>
                        </div>
                    </div>    
                </div>
                <div class="col-1"></div>
                <div class="col-5 bg-light border border-grey rounded">
                    <div class="ml-10px px-1 py-3">
                        
                        <div style="height:340px" class="col  text-center ">
                            <div class="vstack gap-3">
                                <div style="height:300px">
                                <img style="width:450px" id="preview-2" class="mt-4 rounded" 
                                src="{{ isset($poster[2]) ? $poster[2] : '/images/16_9.png' }}" />
                                
                                </div>
                                <div>

                                    <div class="input-group col-12">
                                        <div class="custom-file ">
                                          <input   @error('poster-2') is-invalid @enderror id="poster-2" name="poster-2" type="file" class="custom-file-input">
                                          <label style="width:450px"  class="ml-4 custom-file-label" for="poster-2">16x9</label>
                                        </div>
                                    </div>
                                </div>
                   
                              </div>
                        </div>
                </div>

            </div>
        

        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-md-right text-uppercase "></label>
            <div class="col-2">

              
                <div class="mt-3">
                    <button id="submit" class="btn btn-primary" >Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/videos'">
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
          $("#update_video").submit();
        });

        // image display
        function previewFile(name,element,width,height){

            var file = $("input[name="+name+"]").get(0).files[0]; // selector
    
            if(file){
                var reader = new FileReader();
                reader.onload = function(){
                    $(element).attr("src", reader.result).height(height).width(width); // previewer
                }
                reader.readAsDataURL(file);
            }
        } // preview 

        $("#poster-1").change(function() {
            previewFile('poster-1','#preview-1',185,278);
        });

        $("#poster-2").change(function() {
            //alert('poster-2')
            previewFile('poster-2','#preview-2',450,253);
        });

        

    });
    </script>
@stop