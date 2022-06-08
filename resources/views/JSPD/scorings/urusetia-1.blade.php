
<form id="store_verification" method="post" action="{{ route('scorings.store_verification',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf


      <h5>Pengesahan Urusetia 1</h5>
      <div class="form-check">
        <input 
          class="form-check-input @error('is_verified') is-invalid @enderror" 
          @if(  in_array(auth()->user()->id, $tenderSubmission->verifications->pluck('user_id')->toArray() )) checked disabled @endif
          type="checkbox" 
          name="is_verified" 
          value=1 
   
          />
          @error('is_verified')
          <input  type="hidden" class="form-control @error('is_verified') is-invalid @enderror"  />
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
        <button  @if(  in_array(auth()->user()->id, $tenderSubmission->verifications->pluck('user_id')->toArray() )) checked disabled @endif id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('scorings.index') }}'">
            Cancel 
        </button>
        @include('JSPD.scorings.modal_submit')
        {{-- <script>
          $( document ).ready(function() {
                $( "#submit" ).click(function() {
                    //alert( "Handler for .click() called." );
                    $('#modal_submit').modal('show');
                    e.preventDefault();
                    //$("#store_scorings").submit();
                });

                $( "#agree" ).click(function() {
                  $("#store_verification").submit();
                  $('#modal_submit').modal('hide');
                  //alert( "Handler for .click() called." );
                });
          });
          </script> --}}
      </div>
</form>