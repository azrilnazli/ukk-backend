

<div class="d-flex col-9 bg-secondary rounded align-items-center">

    <div class="col-1 p-2">
        <div class="p-3 col-1 d-flex align-items-center">
            <input
            class=" @error('is_verified') is-invalid @enderror"
            type="checkbox"
            name="is_verified"
            value=1

            @if(!empty($pitchingScoring))
                disabled
            @endif

            @if( old('is_verified',  !empty($pitchingScoring) ? $pitchingScoring->is_comply  : null) ) checked @endif
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
            <strong>{{ $pitchingScoring->user->name }}  ({{ $pitchingScoring->user->email }})</strong>
        </div>
    </div>


    <div class="d-flex col-9 bg-dark">
        <div class="col-2 p-2">
            DITANDA :
        </div>
        <div class="p-2">
            <strong>{{ \Carbon\Carbon::parse( $pitchingScoring->created_at  )->format('d/m/Y H:i:s') }}</strong>
        </div>
    </div>

