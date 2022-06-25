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
    <label for="module" class="col-md-4 col-form-label text-md-right">{{ __('Module') }}</label>
    <div class="col-md-6">
        <input
            id="module"
            type="text"
            class="form-control
            @error('module') is-invalid @enderror"
            name="module"
            value="{{ old('module', !empty($tenderRequirement) ? $tenderRequirement->module : null ) }}"
            >

        @error('module')
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
        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('tender-requirements.index')}}'">
            Cancel
        </button>
    </div>
</div>
