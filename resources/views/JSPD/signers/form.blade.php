<div class="row">

    <div class="col-3">
        <h5>Assign Signer</h5>
        <div class="form-check">
        @foreach($signers as $signer)
            <input 
                value="{{ $signer->id }}" 
                name="signers[]" 
                class="form-check-input" 
                type="checkbox" 
                value="{{ $signer->id }}" 
        
                />
                                                
            <label class="form-check-label text-muted">
                <strong>{{ $signer->name }}</strong> ( {{ $signer->email }}  )
            </label>
            <br />
        @endforeach
        </div>
    </div>
    <div class="col-5">
        <h5>Assign Urusetia</h5>
        <div class="form-check">
        @foreach($admins as $admin)
            <input value="{{ $admin->id }}" name="admins[]" class="form-check-input" type="checkbox" value="{{ $admin->id }}" />
                                                  
            <label class="form-check-label text-muted">
                <strong>{{ $admin->name }}</strong> ( {{ $admin->email }}  )
            </label>
            <br />
        @endforeach
        </div>
    </div>
</div>


