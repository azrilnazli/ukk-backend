<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-dark">
            <div class="card-header">Users </div>
            <div class="card-body">

                <div class="row">

                    @foreach($roles as $role)
                    <!-- Role -->
                    <div class="col-md-2">
                        <div class="info-box bg-secondary">
                                {{-- <span class="info-box-icon"><i class="far fa-user"></i></span> --}}
                                <div class="info-box-content">
                                        <span class="info-box-text text-uppercase">{{ $role->name }}</span>
                                        <span class="info-box-number">{{ $role->users_count }}</span>
                                </div>
                        </div>
                    </div>
                    <!-- ./ Role -->
                    @endforeach

                </div> <!-- ./row -->
            </div>

        </div>
    </div>
</div>
<!-- ./Horizontal Form -->
