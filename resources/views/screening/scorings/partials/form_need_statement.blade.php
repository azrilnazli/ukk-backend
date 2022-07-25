<h5>PEMATUHAN NEED STATEMENT</h5>
<div class="d-flex col-8 ">
    <div class="p-3 d-flex align-items-center ">
           <input
              class=" @error('need_statement_comply') is-invalid @enderror"
              type="checkbox"
              name="need_statement_comply"
              value=1
              @if( old('need_statement_comply',  $screeningScoring ? $screeningScoring->need_statement_comply  : null) ) checked @endif
              />
              @error('need_statement_comply')
              <input  type="hidden" class="form-control @error('need_statement_comply') is-invalid @enderror"  />
              <span class="p-3 invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

    </div>

    <div class="p-2 d-flex  ">
        <span>Dengan ini saya mengaku proposal ini mematuhi keperluan NEED STATEMENT</span>
    </div>
</div>

