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
    <div class="col-md-6">
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
    <div class="col-md-6">
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
    <label for="login_text" class="col-md-4 col-form-label text-md-right">{{ __('Login Text') }}</label>

    <div class="col-md-6">
        <textarea
            class="form-control
            @error('login_text') is-invalid @enderror"
            rows="8" id="login_text"
            name="login_text"
            style="resize:none"

            >{{ old('login_text', !empty($tenderDetail) ? $tenderDetail->login_text : null ) }}</textarea>
        @error('login_text')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="dashboard_text" class="col-md-4 col-form-label text-md-right">{{ __('Dashboard Text') }}</label>

    <div class="col-md-6">
        <textarea
            class="form-control
            @error('dashboard_text') is-invalid @enderror"
            rows="8" id="dashboard_text"
            name="dashboard_text"
            style="resize:none"

            >{{ old('dashboard_text', !empty($tenderDetail) ? $tenderDetail->dashboard_text : null ) }}</textarea>
        @error('dashboard_text')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="proposal_text" class="col-md-4 col-form-label text-md-right">{{ __('Proposal Text') }}</label>

    <div class="col-md-6">
        <textarea
            class="form-control
            @error('proposal_text') is-invalid @enderror"
            rows="8"
            id="proposal_text"
            name="proposal_text"
            style="resize:none"

            >{{ old('proposal_text', !empty($tenderDetail) ? $tenderDetail->proposal_text : null ) }}</textarea>
        @error('proposal_text')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="proposal_text" class="col-md-4 col-form-label text-md-right">{{ __('Requirements') }}</label>

    <div class="col-md-6">
        @if($requirements)
            @foreach($requirements as $requirement)
            <div class="form-check">
                <input
                    value="{{ $requirement->id }}"
                    name="requirements[]"
                    class="form-check-input"
                    @if( $tenderDetail->tender_requirements->pluck('id')->contains($requirement->id)) checked @endif
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
    <label for="login_text" class="col-md-4 col-form-label text-md-right"></label>
    <div class="col-md-6">
        <button id="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='/tenders'">
            Cancel
        </button>
    </div>
</div>
