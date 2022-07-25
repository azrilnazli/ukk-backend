<h5>KESEUAIAN</h5>
<div class="d-flex col-8">

    <div class="p-2">

    </div>
    <div class="p-2">
        Adakah sesuai untuk siaran ?
        @error('is_suitable')
            <input  type="hidden" class="form-control @error('is_suitable') is-invalid @enderror"  />
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>



    <div class="ml-auto p-2">


            <select
                id="is_suitable"
                name="is_suitable"
                class="custom-select  @error('is_suitable') is-invalid @enderror"
                >
                <option value="-1">Choose...</option>

                    <option
                        value="1"
                        @if ( old('is_suitable', !empty($screeningScoring) ? $screeningScoring->is_suitable : '-1' ) == 1 ) selected @endif
                    >YA</option>==

                    <option
                    value="0"
                    @if ( old('is_suitable', !empty($screeningScoring) ? $screeningScoring->is_suitable : '-1' ) == 0 ) selected @endif
                >TIDAK</option>

            </select>

    </div>

</div>


