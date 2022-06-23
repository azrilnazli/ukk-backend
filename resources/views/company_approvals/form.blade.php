
<form method="POST" action="{{ route('company-approvals.update', $companyApproval->id) }}" >
    @csrf
    @method('PUT')
    <div class="card card-secondary" >

        <div class="card-header">
            Administration
        </div><!-- /.card-header -->

        @if( count($comments) != 0 )
        <div class="card-body pl-5 pr-5">
            <div class="form-group">
                <label>Previous Conversation</label>
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

        <div class="card-body pl-5 pr-5">

            <div class="form-group ">

                <dl class="row">
                    <dt class="col-md-2">Current Status</dt>
                    <dd class="col-md-4">
                        <span class='badge badge-dark'> {{ $companyApproval->status }}</span>
                    </dd>
                </dl>

          </div>

            <div class="form-group">

                <dl class="row">
                    <dt class="col-md-2">Update Status</dt>
                    <dd class="col-md-8">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                              <input value=1 {{ $companyApproval->is_approved == 1 ? 'checked' : null }} type="radio" class="form-check-input" name="is_approved">Approve
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <label class="form-check-label">
                              <input value=0 {{ $companyApproval->is_approved == 0 ? 'checked' : null }} type="radio" class="form-check-input" name="is_approved">Reject
                            </label>
                          </div>
                    </dd>
                </dl>

            </div>


            <div class="form-group ">
                    <label>Message to Vendor </label>
                    <textarea class="form-control @error('message') is-invalid @enderror" rows="8" id="message" name="message" style="resize:none"  autocomplete="message"></textarea>
                    @error('message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="mt-3">
                    <button id="submit" class="btn btn-primary" >Submit</button>

                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('company-approvals.index')}}'">
                        Cancel
                    </button>
                    </div>
            </div>


        </div><!-- /.card-body -->
    </div><!-- /.card -->
    </form>
