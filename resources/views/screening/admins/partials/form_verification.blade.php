

<div class="d-flex col-9 bg-warning rounded align-items-center">

    <div class="col-1 p-2">
        <div class="p-3 col-1 d-flex align-items-center">
            <input
            class=" @error('is_verified') is-invalid @enderror"
            type="checkbox"
            name="is_verified"
            value=1

            @if(!empty($screeningVerification))
                disabled
            @endif

            @if( old('is_verified',  !empty($screeningVerification) ? $screeningVerification->is_verified  : null) ) checked @endif
            />
        </div>
    </div>

    <div class="p-2">
        <span>Dengan ini saya mengaku keputusan pemarkahan yang telah dibuat adalah sahih dan muktamad</span>
    </div>
</div>

@error('is_verified')
<div class="d-flex col bg-secondary rounded align-items-center">
<input  type="hidden" class="form-control @error('is_verified') is-invalid @enderror"  />
<span class="p-3 invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
</div>
@enderror



    <div class="d-flex col-9 bg-dark">

        <div class="col-2 p-2">
            PENANDA :
        </div>
        <div class="p-2">
            <strong>{{ $screeningVerification->user->name }}  ({{  $screeningVerification->user->email }})</strong>
        </div>
    </div>

    @if(!empty($tenderSubmission->screening_verification))
    <div class="d-flex col-9 bg-dark">
        <div class="col-2 p-2">
            DITANDA :
        </div>
        <div class="p-2">
            <strong>{{ \Carbon\Carbon::parse( $tenderSubmission->screening_verification->created_at  )->format('d/m/Y H:i:s') }}</strong>
        </div>
    </div>
    @endif
