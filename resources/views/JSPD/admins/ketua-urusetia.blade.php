
@if( count($tenderSubmission->scorings) == 3 && count($tenderSubmission->verifications) == 2  )
<form id="store_approval" method="post" action="{{ route('jspd-admins.store',  ['tenderSubmission' => $tenderSubmission->id] ) }}" >
@csrf
      <h5>Pengesahan Ketua Urusetia</h5>
      <div class="form-check">
        <input
          class="form-check-input @error('is_approved') is-invalid @enderror"
          @if( !empty($tenderSubmission->approval) && $tenderSubmission->approval->pluck('user_id')->contains( auth()->user()->id )) checked disabled @endif
          type="checkbox"
          name="is_approved"
          value=1

          />
          @error('is_approved')
          <input  type="hidden" class="form-control @error('is_approved') is-invalid @enderror"  />
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>

      <label class="form-check-label ml-3">
        Adalah dengan ini diakui bahawa laporan pensyoran yang dibuat adalah sahih dan muktamad.
          <p class="font-weight-bold mt-3">
            {{ auth()->user()->name }} ({{ auth()->user()->email }})<br />
            @if(  !empty($tenderSubmission->approval) && $tenderSubmission->approval->pluck('user_id')->contains( auth()->user()->id ) )
                {{ \Carbon\Carbon::parse( $tenderSubmission->approval->created_at )->format('d/m/Y H:i:s')}}
            @else
                {{ \Carbon\Carbon::parse( date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}}
            @endif
          </p>
      </label>

      <div class="mt-2">
        <button   @if(  !empty($tenderSubmission->approval) && $tenderSubmission->approval->pluck('user_id')->contains( auth()->user()->id )) checked disabled @endif id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('scorings.index') }}'">
            Cancel
        </button>
        @include('JSPD.scorings.modal_submit')
      </div>
</form>
@else
<h5> Penandaan belum lengkap. </h5>
@endif
