<h5>PEMATUHAN NEED STATEMENT</h5>
<div class="d-flex col-8">

    <div class="p-2">

    </div>
    <div class="p-2">
        Adakah mematuhi kriteria '<i>NEED STATEMENT</i>' ?
        @error('need_statement_comply')
            <input  type="hidden" class="form-control @error('need_statement_comply') is-invalid @enderror"  />
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>



    <div class="ml-auto p-2">


            <select
                id="need_statement_comply"
                name="need_statement_comply"
                class="custom-select  @error('need_statement_comply') is-invalid @enderror"
                @if(!empty($screeningScoring)) disabled @endif
                >
                <option value="-1">Choose...</option>

                    <option
                        value="1"
                        @if ( old('need_statement_comply', !empty($screeningScoring) ? $screeningScoring->need_statement_comply : '-1' ) == 1 ) selected @endif
                    >YA</option>==

                    <option
                    value="0"
                    @if ( old('need_statement_comply', !empty($screeningScoring) ? $screeningScoring->need_statement_comply : '-1' ) == 0 ) selected @endif
                >TIDAK</option>

            </select>

    </div>
</div>
