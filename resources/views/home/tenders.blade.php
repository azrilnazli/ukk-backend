
<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-dark">
            <div class="card-header">Tender : {{ $tender->title }} </div>
            <div class="card-body">

                <div class="row">
                    <!-- Expired -->
                    <div class="col-md-3">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Date Range</span>
                                        <span class="info-box-number">
                                            <span class="badge badge-light">{{ $tender->start }}</span>
                                            -
                                            <span class="badge badge-light">{{ $tender->end }}</span>
                                        </span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Expired -->

                    <!-- Apply -->
                    <div class="col-md-3">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Company Apply/Approved</span>
                                        <span class="info-box-number"> {{ $tender->company_approvals->count() }}/{{ $tender->company_approvals_approved->count() }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Apply -->

                    <!-- Proposal -->
                    <div class="col-md-3">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Proposal Apply/Approved</span>
                                        <span class="info-box-number">0/0</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./Proposal -->


                </div> <!-- ./row -->
            </div>

        </div>
    </div>
</div>
