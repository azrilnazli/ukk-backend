<h2 class="text-uppercase">ulasan</h2>
<div class="form-group row">
    {{-- <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label> --}}

    <div class="col-md-6">
       <textarea class="form-control @error('comment') is-invalid @enderror" rows="8" id="comment" name="comment" style="resize:none" required autocomplete="comment">{{ old('comment') }}</textarea>
        @error('comment')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
