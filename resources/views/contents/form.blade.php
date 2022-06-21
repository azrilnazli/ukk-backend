<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
    <div class="col-md-6">
        <input
            id="title"
            type="text"
            class="form-control
            @error('title') is-invalid @enderror"
            name="title"
            value="{{ old('title', !empty($content) ? $content->title : null ) }}"
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
            value="{{ old('module', !empty($content) ? $content->module : null ) }}"
            >

        @error('module')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

    <div class="col-md-6">
        <textarea
            class="form-control
            @error('content') is-invalid @enderror"
            rows="8" id="content"
            name="content"
            style="resize:none"

            >{{ old('content', !empty($content) ? $content->content : null ) }}</textarea>
        @error('content')
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
