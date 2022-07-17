<div class="d-flex col-6 bg-warning ">
    <div class="p-3 d-flex align-items-center bg-warning">
           <input
              class=" @error('is_comply') is-invalid @enderror"
              type="checkbox"
              name="is_comply"
              value=1
              @if( old('is_comply',  $pitchingScoring ? $pitchingScoring->is_comply  : null) ) checked @endif
              />
              @error('is_comply')
              <input  type="hidden" class="form-control @error('is_comply') is-invalid @enderror"  />
              <span class="p-3 invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

    </div>

    <div class="ml-auto p-2 d-flex align-items-center bg-warning">
            <span>Dengan ini saya mengaku keputusan pemarkahan yang telah dibuat adalah sahih dan muktamad</span>
    </div>
</div>


        <div class="d-flex col-6 bg-dark">

            <div class="col-2 p-2">
                PENANDA :
            </div>
            <div class="p-2">
                <strong>{{ auth()->user()->name }}  ({{ auth()->user()->email }})</strong>
            </div>
        </div>
        <div class="d-flex col-6 bg-dark">
            <div class="col-2 p-2">
                DITANDA :
            </div>
            <div class="p-2">
                <strong>{{ \Carbon\Carbon::parse( optional($pitchingScoring)->created_at ? optional($pitchingScoring)->created_at : date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}}</strong>
            </div>
        </div>
