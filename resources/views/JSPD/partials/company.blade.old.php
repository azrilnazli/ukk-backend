


      @foreach(\App\Services\TenderSubmissionService::fields($tenderSubmission) as $field)
        @if($tenderSubmission->$field)
        <div class="card-body">
            <span class="badge badge-dark text-uppercase">{{ str_replace('_',' ',$field)}}</span>
            <div class="alert alert-light">
            <span class="lead">{{ $tenderSubmission->$field }}</span>
            </div>
        </div>

        @endif
      @endforeach


      @if($tenderSubmission->video)


        <div class="card-body">
            <span class="badge badge-dark">RAW Video</span>

            <div class="alert alert-light">
<pre>
Filename : <a  class="text-dark" href="/original_video/{{$tenderSubmission->video->id}}/original.mp4">{{ $tenderSubmission->video->original_filename }}</a>
Duration : {{ $tenderSubmission->video->length  }}
</pre>
            </div>
        </div>

      @endif



      @if($tenderSubmission->video)
        @if($tenderSubmission->video->is_ready)

        <div class="card-body">
            <span class="badge badge-dark">Video</span>
            <div class="alert alert-light">


                    <video-js id="my_video_1" class="vjs-default-skin vjs-big-play-centered" controls preload="auto"
                    data-setup='{
                    "fluid": true,
                    "poster": "{{ Storage::disk('streaming')->url($tenderSubmission->video->id . '/thumbnails/poster.jpg')}}"
                    }'>
                        <source src=" {{ route('assets', ['video' =>$tenderSubmission->video->id, 'playlist' => 'playlist.m3u8']) }} " type="application/x-mpegURL">

                    </video-js>

                    <script src="/js/videojs/video.js"></script>
                    <script src="/js/videojs//videojs-http-streaming.js"></script>
                    <script src="/js/videojs/videojs-contrib-quality-levels.js"></script>
                    <script src="/js/videojs/videojs-hls-quality-selector.min.js"></script>

                    <script>
                        var player = videojs('my_video_1');
                        player.hlsQualitySelector();
                    </script>

                </div>
        </div>

        @endif
      @endif

      @if($tenderSubmission->is_pdf_cert_uploaded)
      <div class="card-body">
        <span class="badge badge-dark">PDF</span>
        <div class="alert alert-light">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <div style="height:500px" id="document"></div>
            <script>PDFObject.embed("/storage/proposals/{{$tenderSubmission->id}}/proposal.pdf", "#document");</script>
        </div>
      </div>

      @endif
      <!-- /.card-body -->
      <div class="card-body">

        Created at : <strong>{{ $tenderSubmission->created_at }}</strong> around {{ $tenderSubmission->created_at->diffForHumans() }}
        <br />
        Updated at : <strong>{{ $tenderSubmission->updated_at }}</strong> around {{ $tenderSubmission->updated_at->diffForHumans() }}
       </div>
    </div>


