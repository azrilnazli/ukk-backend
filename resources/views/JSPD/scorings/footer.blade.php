
      <div class="form-group">
        <h5>Pengesahan</h5>
        <div class="form-check">
            <input
              class="form-check-input @error('pengesahan_comply') is-invalid @enderror"
              @if(!empty($data)) disabled @endif
              type="checkbox"
              name="pengesahan_comply"
              value=1
              @if(old('pengesahan_comply',  optional($data)->pengesahan_comply) == 1) checked @endif
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
              {{ auth()->user()->name }}  ({{ auth()->user()->email }})<br />
              {{ auth()->user()->occupation }}<br />
              {{ \Carbon\Carbon::parse( optional($data)->created_at ? optional($data)->created_at : date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}}
            </p>
        </label>
    </div>

      <div class="mt-5">

        <button type="button" @if(!empty($data)) disabled @endif id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('scorings.tasks') }}'">
            Cancel
        </button>
        @include('JSPD.scorings.modal_submit')
        <script>
          $( document ).ready(function() {
                $( "#submit" ).click(function() {
                    //alert( "Handler for .click() called." );
                    $('#modal_submit').modal('show');
                    e.preventDefault();
                    //$("#store_scorings").submit();
                });

                $( "#agree" ).click(function() {
                  $("#store_scorings").submit();
                  $('#modal_submit').modal('hide');
                  //alert( "Handler for .click() called." );
                });
          });
          </script>
      </div>
