
    <div class="form-group row">
        <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tender Category') }}</label>

        <div class="col-md-6">
            <select
                name="tender_detail_id"
                class="form-control
                @error('tender_detail_id') is-invalid @enderror"
            />
                <option value="0">Choose Tender Detail </option>
                <option disabled>--------------------</option>
                @foreach($tenderDetails as $detail)
                <option
                @if (
                    $detail->id == old(
                                    'tender_detail_id',
                                    !empty($companyApproval) ? $companyApproval->tender_detail_id : null
                                    )
                    )
                    selected="selected"
                @endif
                value="{{$detail->id}}">{{$detail->title}}</option>
                @endforeach
            </select>
            @error('channel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


<div class="form-group row">
    <label for="login_text" class="col-md-4 col-form-label text-md-right"></label>
    <div class="col-md-6">
        <button id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='/tenders'">
            Cancel
        </button>
    </div>
</div>
