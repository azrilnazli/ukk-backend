
<!-- Horizontal Form -->
<div class="row">
    <div class="col">
    <div class="card card-dark">
        <div class="card-header">General Info </div>
        <div class="card-body">

            <div class="row">
               <!-- Total -->
                <div class="col-md-2">
                    <div class="info-box bg-secondary">
                            {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                            <div class="info-box-content">
                                    <span class="info-box-text">Total Company</span>
                                    <span class="info-box-number">{{ $company['total'] }}</span>
                            </div>
                    </div>
                </div>
                <!-- ./ Total -->
                <!-- Comment -->
                <div class="col-md-2">
                    <div class="info-box bg-secondary">
                            {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                            <div class="info-box-content">
                                    <span class="info-box-text">Total Comment</span>
                                    <span class="info-box-number">{{ $comment['total'] }}</span>
                            </div>
                    </div>
                </div>
                <!-- ./ Comment -->
                <!-- Video -->
                <div class="col-md-2">
                    <div class="info-box bg-secondary">
                            {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                            <div class="info-box-content">
                                    <span class="info-box-text">Total Video</span>
                                    <span class="info-box-number">{{ $video['total'] }}</span>
                            </div>
                    </div>
                </div>
                <!-- ./ Video -->
                <div class="card-footer text-muted ">
                    <div class="card-text ">Company by State</div>
                    @foreach($states as $state)
                        <button type="button" class="p-1 m-2 btn btn-dark btn-sm">
                        <span class="text-uppercase">{{ $state->states}}</span> <span class="badge badge-light">{{ $state->count }}</span>
                    </button>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<!-- ./Horizontal Form -->
