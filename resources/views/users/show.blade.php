@extends('layouts.master')

@section('title', 'Create User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('User Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __(ucfirst($user->name)) }}</li>
    </ol>
</nav>
@stop

@section('head')
    <link href="/css/video-js.css" rel="stylesheet" />
    <link href="/css/videojs-hls-quality-selector.css" rel="stylesheet" />
@stop

@section('content')

<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">User Info</div>
            <div class="card-body">


                {{-- <dl class="row">
                    @foreach($user->toArray() as $key => $value)
                        <dt class="col-sm-4 text-right text-uppercase">{{ str_replace("_", " " , $key) }}</dt>
                        <dd class="col-sm-8 text-left">{{ $value }}</dd>
                    @endforeach
                </dl> --}}
                <dl class="row">
                <dt class="col-sm-4 text-right text-uppercase">user id</dt>
                <dd class="col-sm-8 text-left"><span class="badge badge-warning">{{ $user->id }}</span></dd>

                <dt class="col-sm-4 text-right text-uppercase">user email</dt>
                <dd class="col-sm-8 text-left">{{ $user->email }}</dd>

                <dt class="col-sm-4 text-right text-uppercase">phone</dt>
                <dd class="col-sm-8 text-left">{{ $user->phone }}</dd>
                </dl>

            </div>
            <div class="card-footer text-muted ">

                Registered <span>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span></div>

        </div>
    </div>
</div>

@if ($user->company)
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">Company Info</div>
            <div class="card-body">


                {{-- <dl class="row">
                    @foreach($user->company->toArray() as $key => $value)
                        <dt class="col-sm-4 text-right text-uppercase">{{ str_replace("_", " " , $key) }}</dt>
                        <dd class="col-sm-8 text-left">{!! $value === 1 ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : $value!!}</dd>
                    @endforeach
                </dl> --}}


                <dl class="row">

                        <dt class="col-sm-4 text-right text-uppercase">company id</dt>
                        <dd class="col-sm-8 text-left"><span class="badge badge-warning"> {{ $user->company->id }}</span></dd>

                        <dt class="col-sm-4 text-right text-uppercase">Is Approved ?</dt>
                        <dd class="col-sm-8 text-left">


                            @if($user->company->is_approved == 1 && $user->company->is_completed == 1 )
                            <span class="badge badge-success">Approved</span>
                            @endif

                            @if($user->company->is_rejected == 1  && $user->company->is_completed == 0 )
                            <span class="badge badge-danger">Rejected</span>
                            @endif

                            @if($user->company->is_rejected == 1  && $user->company->is_completed == 1 )
                            <span class="badge badge-warning">Resubmission</span>
                            @endif

                            @if($user->company->is_rejected == 0 && $user->company->is_approved == 0 )
                              <span class="badge badge-info">Pending</span>
                            @endif

                        </dd>

                        <dt class="col-sm-4 text-right text-uppercase">company name</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->name }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company email</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->email }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company phone</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->phone }}</dd>

                </dl>
            </div>
            <div class="card-footer text-muted">Submitted <span>{{ \Carbon\Carbon::parse($user->company->created_at)->diffForHumans() }}</div>
        </div>
    </div>
</div>
@endif


@if($user->proposals)
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">PROPOSAL</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="5%">ID</td>
                        <th>CATEGORY</td>
                        <th>PROGRAMME CODE</td>
                        <th>ATTACHMENTS</th>
                    </tr>
                    @foreach($user->proposals as $proposal)
                    <tr>
                        <td><span class="badge badge-warning">{{$proposal->id}}</span></td>
                        <td>
                            {{$proposal->tender->type}}-{{$proposal->tender->tender_category}}
                            <br />
                            <small>
                            Submitted <span>{{ \Carbon\Carbon::parse($proposal->created_at)->diffForHumans() }}<br />
                            Updated <span>{{ \Carbon\Carbon::parse($proposal->updated_at)->diffForHumans() }}
                            </small>
                        </td>
                        <td>{{$proposal->tender->programme_code}}</td>
                        <td>

                            @if($proposal->is_pdf_cert_uploaded)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PDF_{{$proposal->id}}">
                                    PDF
                                </button>
                                <!-- PDF Modal -->
                                <div class="modal fade" id="PDF_{{$proposal->id}}" tabindex="-1" role="dialog" aria-labelledby="PDFLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="PDFLabel">PDF</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                                                <div style="height:500px" id="document_{{$proposal->id}}"></div>
                                                <script>PDFObject.embed("/storage/proposals/{{$proposal->id}}/proposal.pdf", "#document_{{$proposal->id}}");</script>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./PDF MODAL -->
                            @endif

                            @if($proposal->video->is_ready)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#video_{{ $proposal->video->id }}">
                                    VIDEO
                                </button>
                                <!-- video Modal -->
                                <script>

                                    function closePlayer_{{ $proposal->video->id }}(){
                                        $( document ).ready(function() {
                                            // Handler for .ready() called.
                                            console.log('close and ready');
                                            $('video').each(function() {
                                                $(this).get(0).pause();
                                            });
                                        });

                                     }
                                </script>
                                <div class="modal fade" id="video_{{ $proposal->video->id}}" tabindex="-1" role="dialog" aria-labelledby="videoLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="videoLabel">VIDEO</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">

                                                <!-- video -->
                                                <div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8">

                                                    <video-js id="my_video_{{$proposal->video->id}}" class="vjs-default-skin vjs-big-play-centered" controls preload="auto"
                                                            data-setup='{
                                                                "fluid": true,
                                                                "poster": "{{ Storage::disk('streaming')->url( $proposal->video->id . '/thumbnails/poster.jpg')}}"
                                                            }'>
                                                          <source src=" {{ route('assets', ['video' => $proposal->video->id, 'playlist' => 'playlist.m3u8']) }} " type="application/x-mpegURL">
                                                    </video-js>

                                                    <script src="/js/videojs/video.js"></script>
                                                    <script src="/js/videojs//videojs-http-streaming.js"></script>
                                                    <script src="/js/videojs/videojs-contrib-quality-levels.js"></script>
                                                    <script src="/js/videojs/videojs-hls-quality-selector.min.js"></script>

                                                    <script>
                                                        var player_{{ $proposal->video->id}} = videojs('my_video_{{$proposal->video->id}}');
                                                        player_{{ $proposal->video->id}}.hlsQualitySelector();
                                                    </script>

                                                </div>
                                                <!-- ./video -->

                                            </div>
                                            <div class="modal-footer">
                                                <button onClick="closePlayer_{{ $proposal->video->id }}()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ./video MODAL -->
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Comment -->
@if(count($user->messages) > 0 )
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">Comment</div>
            <div class="card-body pl-5 pr-5">
                <label>Comments </label>
                @foreach($user->messages as $comment)
                <div class="alert alert-secondary" role="alert">
                    <dl class="row">
                        <dt class="col-lg-3"><span class="badge badge-light">{{$comment->user->name }}</span></dt>
                        <dd class="col-lg-9">{{$comment->message}}</dd>
                    </dl>
                    <small><i>{{$comment->created_at->diffForHumans() }}</i></small>
                </div>
                @endForeach
            </div>
            <div class="card-footer text-muted ">

            </div>

        </div>
    </div>
</div>
@endif
<!-- ./Comment -->

@stop
