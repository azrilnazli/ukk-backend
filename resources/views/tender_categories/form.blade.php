
<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tender Detail') }}</label>

    <div class="col-md-6">
        <select
            name="tender_detail_id"
            class="form-control
            @error('tender_detail_id') is-invalid @enderror"
        >

            <option value="0">Choose Tender Detail </option>
            <option disabled>--------------------</option>
            @foreach($tenderDetails as $detail)
            <option

            @if(
                old(
                    'tender_detail_id',
                    !empty($tenderCategory) ? $tenderCategory->tender_detail_id : null
                    ) ==  $detail->id
                )
                selected="selected"
            @endif

            value="{{ $detail->id }}">{{ $detail->title }}</option>

            @endforeach

        </select>
        @error('tender_detail_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
    <div class="col-md-6">
        <input
            id="title"
            type="text"
            class="form-control
            @error('title') is-invalid @enderror"
            name="title"
            value="{{ old('title', !empty($tenderRequirement) ? $tenderRequirement->title : null ) }}"
            >

        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="descriptiion" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

    <div class="col-md-6">
        <textarea
            class="form-control
            @error('description') is-invalid @enderror"
            rows="8" id="descriptiion"
            name="description"
            style="resize:none"

            >{{ old('description', !empty($tenderRequirement) ? $tenderRequirement->description : null ) }}</textarea>
        @error('description')
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
