

    <div class="col card bg-light">

      {{-- <div class="card-header">
        <div class="card-title">
          <label class="badge badge-warning p-2 text-uppercase ">{{$tenderSubmission->user->company->id}}</label> Proposal by {{ $tenderSubmission->user->company->name }}
          </div>

      </div> --}}
      {{-- <div class="card-item text-right">
        <span class="badge badge-warning text-uppercase ">CATEGORY</span> : {{ $tenderSubmission->tender->type }} - {{ $tenderSubmission->tender->programme_category }}
        <span class="badge badge-warning text-uppercase ">CODE</span> : {{ $tenderSubmission->tender->programme_code }}
        <span class="badge badge-warning text-uppercase ">CHANNEL</span> : {{ $tenderSubmission->tender->channel }}
      </div>
      <hr /> --}}
      <div class="card-body">
        <h2>Theme</h2>
        {{ $tenderSubmission->theme }}
      </div>
      <hr />
      <div class="card-body">
        <h2>Genre</h2>
        {{ $tenderSubmission->genre }}
      </div>
      <hr />
      <div class="card-body">
        <h2>Concept</h2>
        {{ $tenderSubmission->concept }}
      </div>
      <hr />
      <div class="card-body">
        <h2>Synopsis</h2>
        {{ $tenderSubmission->synopsis }}
      </div>
      <hr />

      @if($tenderSubmission->video)
        @if($tenderSubmission->video->is_ready)

        <div class="card-body">
            <h2>Video</h2>

                <div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8">

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
        <h2>PDF</h2>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <div style="height:500px" id="document"></div>
        <script>PDFObject.embed("/storage/proposals/{{$tenderSubmission->id}}/proposal.pdf", "#document");</script>
      </div>

      @endif
      <!-- /.card-body -->


  </div>
  <!-- /.card -->
