<div class="form-group">
    <h5>Pengesahan</h5>
    <div class="form-check">
        <input
          class="form-check-input @error('is_comply') is-invalid @enderror"

          type="checkbox"
          name="is_comply"
          value=1
          {{-- @if(old('is_comply',  optional($data)->is_comply) == 1) checked @endif
          /> --}}
          @error('is_comply')
          <input  type="hidden" class="form-control @error('is_comply') is-invalid @enderror"  />
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
    </div>
    <label class="form-check-label ml-3">
        <span>Dengan ini saya mengaku keputusan pemarkahan yang telah dibuat adalah sahih dan muktamad</span>
        <br />
        <span class="font-weight-bold mt-3">
          {{ auth()->user()->name }}  ({{ auth()->user()->email }})<br />
          {{ auth()->user()->occupation }}<br />
          {{-- {{ \Carbon\Carbon::parse( optional($data)->created_at ? optional($data)->created_at : date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}} --}}
        </span>
    </label>
</div>
