<h5>PEMATUHAN</h5>
<div class="d-flex col-8">

<div class="p-2">

</div>
<div class="p-2">
    Adakah mematuhi garis panduan siaran ?
    @error('pematuhan')
        <input  type="hidden" class="form-control @error('pematuhan') is-invalid @enderror"  />
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>



<div class="ml-auto p-2">


        <select
            id="pematuhan"
            name="pematuhan"
            class="custom-select  @error('pematuhan') is-invalid @enderror"
            >
            <option value="-1">Choose...</option>

                <option
                    value="1"
                    @if ( old('pematuhan', !empty($screeningScoring) ? $screeningScoring->pematuhan : '-1' ) == 1 ) selected @endif
                >SEPENUHNYA</option>==

                <option
                value="0"
                @if ( old('pematuhan', !empty($screeningScoring) ? $screeningScoring->pematuhan : '-1' ) == 0 ) selected @endif
            >SEBAHAGIAN</option>

        </select>

</div>
</div>
