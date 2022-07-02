
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
                     $.each(JSON.parse(data.encoding), function(key, value) {
                         console.log(value); // display to console
                         // html progress bar
                         $('#videos').append('<div id="progressbar" class="progress-bar" role="progressbar"></div>')
                         $('#progress').html(value.progress)
                         $('#progressbar').css('width', value.progress +'%');
                     });

                 },
                 error: function(error){
                     console.log(error); // if error 5xx
                 }

             });
         }
         //setInterval(getEncodingStatus, 2000); // request every 2 secs

         function getVideos(){
             var cards = $();

             $.ajax({
                 type: 'GET', // mode is GET
                 url: '/api/video/encoding_status', // laravel api route
                 dataType: 'json', // JSON
                 success: function (data) { // response 200

                     // laravel send collection as JSON, need to parse as JSON
                      $.each(JSON.parse(data.encoding), function(key, value) {
                         console.log(value); // display to console
                         cards = cards.add(createCard(value));

                     })

                     $('#videos').html(cards);
                 },
                 error: function(error){
                     console.log(error); // if error 5xx
                 }
             }); // ajax


          } // getVideos()

        setInterval(getVideos, 2000); // request every 2 secs

        function createCard(cardData) {
            var cardTemplate = [
                '<p><strong>video id : </strong>' + cardData.id + ' - <strong>filename :</strong> ' + cardData.original_filename + '</p>',
                '<p><small><strong>company : </strong>' + cardData.company.title + ' - <strong>uploaded :</strong> ' + cardData.date+ '</small></p>',
                '<p><strong>size : </strong>' + cardData.uploaded_size + ' - <strong>length :</strong> ' + cardData.length + '</p>',
                '<div class="progress">',
                    '<div style="width:'+ cardData.progress +'%" id="progressbar_'+ cardData.id +'" class="progress-bar" role="progressbar">'+ cardData.progress +'%</div>',
                '</div>'
            ];

            return $(cardTemplate.join(''));
        }


     }); // jquery
 </script>

<div class="card card-dark">
    <div class="card-header">
        Video Processing Live Monitoring ( Uploaded Videos )
    </div>

    <div class="card-body">
        <!--
          1. list all video that being processed
          2. update progress bar value
        -->

        <div id="videos"></div>

    </div>

    <div class="card-footer text-muted">
       Showing current video encoding process.
    </div>
</div>



@endsection
