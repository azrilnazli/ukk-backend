<div class="row">

    <div class="col-6">
        <h5>Assign Signer</h5>
        <div class="form-check">
            @foreach($signers as $key => $signer)

                <input
                    value="{{ $signer->id }}"
                    name="signers[]"
                    class="form-check-input  @error('signers') is-invalid @enderror"
                    type="checkbox"
                    value="{{ $signer->id }}"
                    @if(in_array(optional($signer)->id, old('signers') ? old('signers') : array() )) checked  @endif
                    @if(in_array(optional($signer)->id, $assigned_signers)) checked @endif

                />

                <label class="form-check-label text-muted">
                    <strong>{{ $signer->name }}</strong> ( {{ $signer->email }}  )
                </label>
                <br />
            @endforeach
            @error('signers')
            <input  type="hidden" class="form-control @error('assessment') is-invalid @enderror"  />
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <h5>Assign Urusetia</h5>
        <div class="form-check">
            @foreach($admins as $admin)

                <input
                    value="{{ $admin->id }}"
                    name="admins[]"
                    class="form-check-input  @error('admins') is-invalid @enderror"
                    type="checkbox"
                    value="{{ $admin->id }}"
                    @if(auth()->user()->id == $admin->id) checked disabled @endif
                    @if(in_array(optional($admin)->id, $assigned_admins)) checked @endif
                />

                <label class="form-check-label text-muted">
                    <strong>{{ $admin->name }}</strong> ( {{ $admin->email }}  )
                </label>
                <br />
            @endforeach
            @error('admins')
            <input  type="hidden" class="form-control @error('assessment') is-invalid @enderror"  />
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>


