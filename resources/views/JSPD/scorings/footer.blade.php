
      <h5>Pengesahan</h5>
      <div class="form-check">
        <input 
          class="form-check-input @error('pengesahan_comply') is-invalid @enderror" 
         
          type="checkbox" 
          name="is_verified" 
          value=1 
          @if(old('pengesahan_comply',  optional($data)->is_verified) == 1) checked @endif
          />
          @error('pengesahan_comply')
          <input  type="hidden" class="form-control @error('pengesahan_comply') is-invalid @enderror"  />
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror 
      </div>
      <label class="form-check-label ml-3">
        Dengan ini saya mengaku keputusan pemarkahan yang telah dibuat adalah sahih dan muktamad
          <p class="font-weight-bold mt-3">
            {{ auth()->user()->name }} ({{ auth()->user()->email }})<br />
            {{ \Carbon\Carbon::parse( date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}}
          </p>
      </label>

      <div class="mt-2">
        <button id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('scorings.index') }}'">
            Cancel 
        </button>
        <script>
          $( document ).ready(function() {
                $( "#submit" ).click(function() {
                //alert( "Handler for .click() called." );
                $("#store_scorings").submit();
              });
          });
          </script>
      </div>
    </div>