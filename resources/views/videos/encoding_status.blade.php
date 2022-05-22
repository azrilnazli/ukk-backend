
@extends('layouts.master')

@section('title', 'EncodingStatus')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Video Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Encoding Status</li>
    </ol>
</nav>
@stop

@section('content')

<script type="text/javascript">
    $(function() { // JQuery is ready

        function getEncodingStatus(){
            $.ajax({
                type: 'GET', // mode is GET
                url: '/api/video/encoding_status', // laravel api route
                dataType: 'json', // JSON
                success: function (data) { // response 200

                    // laravel send collection as JSON, need to parse as JSON
                    $.each(JSON.parse(data.encoding), function(index, value) {
                        console.log(value.id); // display to console
                    });
                },
                error: function(error){
                    console.log(error); // if error 5xx
                }

            });
        }
        setInterval(getEncodingStatus, 2000); // request every 2 secs
    });
</script>

<div class="card card-dark">
    <div class="card-header">
        header
    </div>

    <div class="card-body">

    </div>

    <div class="card-footer">
        footer
    </div>
</div>

 @endsection
