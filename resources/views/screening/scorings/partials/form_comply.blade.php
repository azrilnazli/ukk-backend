<h5>PENGESAHAN</h5>
<div class="d-flex col-8 bg-warning ">
    <div class="p-3 d-flex align-items-center bg-warning">
           <input
              class=" @error('is_comply') is-invalid @enderror"
              type="checkbox"
              name="is_comply"
              value=1
              @if(!empty($screeningScoring)) disabled @endif
              @if( old('is_comply',  $screeningScoring ? $screeningScoring->is_comply  : null) ) checked @endif
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


        <div class="d-flex col-8 bg-dark">

            <div class="col-2 p-2">
                PENANDA :
            </div>
            <div class="p-2">
                @if(!empty($screeningScoring))
                <strong>{{ $screeningScoring->user->name }}  ({{$screeningScoring->user->email }})</strong>
                @else
                <strong>{{ auth()->user()->name }}  ({{ auth()->user()->email }})</strong>
                @endif
            </div>
        </div>
        <div class="d-flex col-8 bg-dark">
            <div class="col-2 p-2">
                DITANDA :
            </div>
            <div class="p-2">
                <strong>{{ \Carbon\Carbon::parse( optional($screeningScoring)->created_at ? optional($screeningScoring)->created_at : date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}}</strong>
            </div>
        </div>
