@extends('layouts.master')

@section('title', 'Create Video')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Video Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Video</li>
    </ol>
</nav>
@stop

@section('content')

<form id="create_video" name="upload" method="POST"  action="{{ route('videos.store') }}">
<div id="uploading_duration"></div>
@csrf
    <!-- Horizontal Form -->
    <div class="card card-dark">

        <div class="card-header">
        <h3 class="card-title">Create New Video</h3>
        <div class="card-tools">
            <a id="submit" class="btn-sm btn-primary" href="#" role="button"><i class="fas fa-plus"></i> Create</a>

            <button  id="upload_progress" class="btn-sm btn-primary disabled">
                <i class="fa fa-cog fa-lg fa-spin"></i> <span id="progress"></span>
            </button>

            

        </div>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">
         
            <div class="form-group row">
                <label for="video"  class="col-sm-2 col-form-label text-md-right">Video </label>
                <div class="input-group col-sm-10">
                  <div class="custom-file" id="uploadForm">
                    <input type="file" id="filename" class="custom-file-input" name="file" >
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                </div>
              </div>

  

            <div class="form-group row" id="title">
                <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Title') }}</label>

                <div class="col-sm-10">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter ..." name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row" id="synopsis">
                <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Synopsis') }}</label>

                <div class="col-sm-10">
                    <textarea  required autocomplete="synopsis" autofocus name="synopsis" class="form-control @error('synopsis') is-invalid @enderror" rows="3" placeholder="Enter ...">{{ old('synopsis') }}</textarea>
                    @error('synopsis')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            
            <div class="form-group row" id="category">
                <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Category') }}</label>

                <div class="col-sm-10">

                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" >
                        @foreach($categories as $key => $category)
                            <option  @if( old('category_id') == $key) {{ 'selected' }}  @endif value="{{ $key }}">{{ $category }}</option>
                        @endForeach
                    </select>                  
                    
                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>




        </div>  
    </div>
</form>


<script type="text/javascript" src="/js/simpleUpload.js"></script>
<script type="text/javascript">
 var $j = jQuery.noConflict();

$j(document).ready(function(){


    $("#submit").click(function() {
        //alert( "Handler for .click() called." );
        $("#create_video").submit();
    });

    $j('#submit').hide();
    $j('#upload_progress').hide();
    $j('#title').hide();
    $j('#synopsis').hide();
    $j('#category').hide();
    $j('#progressBar').hide();
    $j('#progressDiv').hide();
    

    $j('input[name=file]').change(function(){

        startTime = (new Date()).getTime();
      
        $j(this).simpleUpload("{{ route('videos.store_video') }}", {

         
            start: function(file){
                //upload started
                $j('#uploadForm').replaceWith($('#progressBar'));
                $j('#progressBar').show();
                $j('#upload_progress').show();
                $j('#category').show();
                $j('#filename').html(file.name);
                $j('#progress').html("");
                $j('#progressBar').width(0);
            },


            data: {
            "_token": "{{ csrf_token() }}",
            "id": 12,
            },

            progress: function(progress){
                //received progress
                $j('#progress').html("Uploading: " + Math.round(progress) + "%");
                $j('#progressBar').width(progress + "%");
                $j("#progress-bar").attr("style",  "width:" + Math.round(progress) +  "%;" );
            },

            success: function(data){

                if(data.status == 'success'){

                    endTime = (new Date()).getTime();
                    uploadingDuration = (endTime - startTime)/1000;
                    $j('#progress').html("<span class=\"lead\"><i class=\"fas fa-check\"></i>&nbsp;" + data.message + "</span>");
                    //$j('#path').html("<input name='path' type='hidden' value='" + data.path + "' />");
                    $j('#uploading_duration').html("<input name='uploading_duration' type='hidden' value='" + uploadingDuration + "' />");

                    $j('#upload_progress').hide();
                    $j('#submit').show();
                    $j('#title').show();
                    $j('#synopsis').show();

                }else if(data.status == 'error'){
                    $j('#progress').html("<span class=\"text-danger\"><i class=\"fa fa-exclamation-triangle\"></i>&nbsp;" + data.message.file + "</span>");
                }
                
                console.log(data.message.file);
                
               
            },

            error: function(error){
                //upload failed
                //$('#progress').html("Failure!<br>" + error.name + ": " + error.message);
                console.log(data.message);
         
 
                $j('#progress').html("Trailer upload failed!");
                //location.reload();
            }

        });

    });

});
</script>



<div class="progress" id="progressDiv">
    <div style="height:50px" id="progressBar" class="progress-bar bg-success" ></div>
</div>
@stop