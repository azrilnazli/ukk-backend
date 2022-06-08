
      <h5>Pengesahan  ( {{  $tenderSubmission->urusetia->user->name }} )</h5>
      @if(  in_array($tenderSubmission->urusetia->user->id, $tenderSubmission->verifications->pluck('user_id')->toArray() )) 
      <div class="form-check">
        <input 
          class="form-check-input @error('is_verified') is-invalid @enderror" 
          disabled
          type="checkbox" 
          name="is_verified" 
          value=1 
          {{-- @if(old('is_verified',  optional($data)->is_verified) == 1) checked @endif --}}
          @if(old('is_verified',  optional($tenderSubmission->urusetia->user->verification)->is_verified) == 1) checked @endif
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
            {{ $tenderSubmission->urusetia->user->name  }} ({{$tenderSubmission->urusetia->user->email  }})<br />
            {{ \Carbon\Carbon::parse(  optional($tenderSubmission->urusetia->user->verification)->created_at )->format('d/m/Y H:i:s')}}
          </p>
      </label>
      @else 
      <i>Belum disahkan.</i>
      @endif

 