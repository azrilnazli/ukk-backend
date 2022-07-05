

      @if($verification)
        <h5>Pengesahan  ( {{  $verification->user->name }} )</h5>
        {{-- @if(  in_array($verification->user->id, $tenderSubmission->verifications->pluck('user_id')->toArray() ))  --}}
        @if( $tenderSubmission->verifications->pluck('user_id')->contains( $verification->user->id ))
        <div class="form-check">
          <input
            class="form-check-input @error('is_verified') is-invalid @enderror"
            disabled
            type="checkbox"
            name="is_verified"
            value=1
            @if( $tenderSubmission->verifications->pluck('user_id')->contains( $verification->user->id )) checked disabled @endif
            />
            @error('is_verified')
            <input  type="hidden" class="form-control @error('is_verified') is-invalid @enderror"  />
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <label class="form-check-label ml-3">
          Adalah dengan ini diakui bahawa laporan pensyoran yang dibuat adalah sahih dan muktamad.
            <p class="font-weight-bold mt-3">
              <small>verification id = {{ $verification->id }}</small>
              <br />
              {{ $verification->user->name  }} ({{$verification->user->email  }})<br />
              {{-- {{ \Carbon\Carbon::parse(  optional($verification->user->verification)->created_at )->format('d/m/Y H:i:s')}} --}}
              {{ \Carbon\Carbon::parse( $verification->created_at )->format('d/m/Y H:i:s')}}
            </p>
        </label>
        @else
        <i>Belum disahkan.</i>
        @endif
      @else
      <i>Belum disahkan.</i>
      @endif

