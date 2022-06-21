<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
    <div class="col-md-6">
        <input
            id="title"
            type="text"
            class="form-control
            @error('title') is-invalid @enderror"
            name="title"
            value="{{ old('title', !empty($tenderDetail) ? $tenderDetail->title : null ) }}"
            >

        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>
    <div class="col-md-2">
        <input
            id="start"
            type="date"
            class="form-control
            @error('start') is-invalid @enderror"
            name="start"
            value="{{ old('start', !empty($tenderDetail) ? $tenderDetail->start : null ) }}"
            >

        @error('start')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>
    <div class="col-md-2">
        <input
            id="end"
            type="date"
            class="form-control
            @error('end') is-invalid @enderror"
            name="end"
            value="{{ old('end', !empty($tenderDetail) ? $tenderDetail->end : null ) }}"
             >

        @error('end')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="max" class="col-md-4 col-form-label text-md-right">{{ __('Max Proposal') }}</label>
    <div class="col-md-1">
        <input
            id="max"
            type="text"
            class="form-control
            @error('max') is-invalid @enderror"
            name="max"
            placeholder="0"
            value="{{ old('max', !empty($tenderDetail) ? $tenderDetail->max : null ) }}"
            >

        @error('max')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

    <div class="col-md-6">
        <textarea
            class="form-control
            @error('description') is-invalid @enderror"
            rows="8" id="description"
            name="description"
            style="resize:none"

            >{{ old('description', !empty($tenderDetail) ? $tenderDetail->description : null ) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="proposal_text" class="col-md-4 col-form-label text-md-right">{{ __('Requirements') }}</label>

    <div class="col-md-6 mt-2">
        @if($requirements)
            @foreach($requirements as $requirement)
            <div class="form-check">
                <input
                    value="{{ $requirement->id }}"
                    name="requirements[]"
                    class="form-check-input"
                    @if(!empty($tenderDetail))
                        @if( $tenderDetail->tender_requirements->pluck('id')->contains($requirement->id)) checked @endif
                    @endif
                    type="checkbox"  />
                <label class="form-check-label text-muted">
                    {{ ucWords(str_replace('-',' ',$requirement->title)) }}
                </label>
            </div>
            @endforeach
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="is_active" class="col-md-4 col-form-label text-md-right">{{ __('Is Active?') }}</label>

    <div class="col-md-6 mt-2">

            <div class="form-check">
                {{$tenderDetail->is_active }}
                <input
                    value="1"
                    name="is_active"
                    class="form-check-input"
                    @if(!empty($tenderDetail))
                        @if( $tenderDetail->is_active == 1 )) checked @endif
                    @endif
                    type="checkbox"  />

            </div>
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
