<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-dark">
            <div class="card-header">Saringan </div>

            <div class="card-body">
                <!-- Total -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Total</span>
                                        <span class="info-box-number">{{ $proposal['total'] }}</span>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- ./ Total -->
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Registered -->
                    <div class="col-md-3">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Signers/Assigned</span>
                                        <span class="info-box-number">{{ $proposal['signers'] }}/{{ $proposal['assigned'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->




                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Signed</span>
                                        <span class="info-box-number">{{ $proposal['signed'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->

                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Verified</span>
                                        <span class="info-box-number">{{ $proposal['verified'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->


                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">Approved</span>
                                        <span class="info-box-number">{{ $proposal['approved'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">LULUS</span>
                                        <span class="info-box-number">{{ $proposal['success'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->
                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">GAGAL</span>
                                        <span class="info-box-number">{{ $proposal['failed'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->

                    <!-- Registered -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text">BELUM DITANDA</span>
                                        <span class="info-box-number">{{ $proposal['pending'] }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Registered -->
                </div><!-- ./ Row -->
            </div><!-- ./ Card-Body -->

        </div>
    </div>
</div>
<!-- ./Horizontal Form -->
