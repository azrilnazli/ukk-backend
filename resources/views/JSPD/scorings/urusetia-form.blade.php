
@if( count($tenderSubmission->scorings) == 3 )
<form id="store_verification" method="post" action="{{ route('scorings.store_verification',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
      <h5>Pengesahan Urusetia  ( {{ auth()->user()->name  }} )</h5>
      <div class="form-check">
        <input
          class="form-check-input @error('is_verified') is-invalid @enderror"

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
        Adalah dengan ini diakui bahawa laporan pensyoran yang dibuat adalah sahih dan muktamad.
    
          <p class="font-weight-bold mt-3">
            {{ auth()->user()->name  }} ({{  auth()->user()->email }})<br />
            {{ \Carbon\Carbon::parse( date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}}
          </p>
      </label>

  
    <div class="mt-2">
        <button  id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('scorings.index') }}'">
            Cancel
        </button>
        @include('JSPD.scorings.modal_submit')
    </div>
 
</form>
@else
<h5> Penandaan belum lengkap. </h5>
@endif
