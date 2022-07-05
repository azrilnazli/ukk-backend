<div class="card card-secondary">
    <div class="card-header">
        <strong>Comment</strong>
    </div>
    <div class="card-body">

@if( count($comments) != 0 )
<div class="card-body pl-5 pr-5">
    <div class="form-group">
        {{-- <label>Previous Conversation</label> --}}
        @foreach($comments as $comment)
            <div class="alert alert-light text-dark "  role="alert">
                Message by <span class="badge badge-dark">
                    {{ optional($comment->user)->name }}
            </span>
            <small><i>{{$comment->created_at->diffForHumans() }}</i></small>


            <hr />
            <span class="lead"><strong><i>{{$comment->message}}</i></strong></span>


            </div>
        @endForeach
    </div>
</div>
@endif

    </div>
</div>

