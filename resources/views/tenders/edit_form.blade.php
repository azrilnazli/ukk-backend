<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tender Type') }}</label>

    <div class="col-md-6">
        <select  name="type" class="form-control @error('type') is-invalid @enderror">
            <option value="0">Choose type </option>
            <option disabled>--------------------</option>
            @foreach($types as $key => $type)
            <option
            @if ($type == old('type', isset($tender->type) ? $tender->type : null )) selected="selected" @endif
            value="{{$type}}">{{$type}}</option>
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
    <label for="classification" class="col-md-4 col-form-label text-md-right">{{ __('TV Channel') }}</label>

    <div class="col-md-6">
        <select  name="channel" class="form-control @error('channel') is-invalid @enderror">
            <option value="0">Choose channel </option>
            <option disabled>--------------------</option>
            @foreach($channels as $key => $channel)
            <option
            @if ($channel == old('channel', isset($tender->channel) ? $tender->channel : null )) selected="selected" @endif
            value="{{$channel}}">{{$channel}}</option>
            @endforeach
        </select>
        @error('channel')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- <div class="form-group row">
    <label for="classification" class="col-md-4 col-form-label text-md-right">{{ __('Language') }}</label>

    <div class="col-md-6">
        <select  name="language" class="form-control @error('language') is-invalid @enderror">
            <option value="0">Choose Language </option>
            <option disabled>--------------------</option>
            @foreach($languages as $key => $language)
            <option
            @if ($language == old('language', isset($tender->language) ? $tender->language : null )) selected="selected" @endif
            value="{{$language}}">{{$language}}</option>
            @endforeach
        </select>
        @error('language')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div> --}}

<div class="form-group row">

    <label for="classification" class="col-md-4 col-form-label text-md-right">{{ __('Language') }}</label>
    <div class="col-md-6">

        @php
        foreach($tender->languages as $language){
            $selected[] = $language;
        }
        @endphp

        @foreach($languages as $key => $language)
            @php
            $checked = null;
            if(in_array($language , $selected)){
                $checked = true;
            }
            @endphp
            <input  {{ $checked ? 'checked' : null }} type="checkbox" name="languages[]" value="{{$language}}"> {{$language}} <br />
    @endforeach

    </div>
</div>

<div class="form-group row">
    <label for="programme_code" class="col-md-4 col-form-label text-md-right">{{ __('Programme Code') }}</label>

    <div class="col-md-6">
        <input id="programme_code" type="text" class="form-control @error('programme_code') is-invalid @enderror" name="programme_code"  value="{{ $tender->programme_code }}" required  >

        @error('programme_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="number_of_episode" class="col-md-4 col-form-label text-md-right">{{ __('Number of Episode') }}</label>

    <div class="col-md-1">
        <input id="number_of_episode" type="text" class="form-control @error('number_of_episode') is-invalid @enderror" name="number_of_episode" value="{{ $tender->number_of_episode }}" required  >

        @error('number_of_episode')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Duration per Episode') }}</label>

    <div class="col-md-1">
        <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ $tender->duration }}" required  >

        @error('duration')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="tender_category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

    <div class="col-md-6">
        <input id="tender_category" type="text" class="form-control @error('tender_category') is-invalid @enderror" name="tender_category"  value="{{ $tender->tender_category }}" required >

        @error('tender_category')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
  {{-- <div class="form-group row">
      <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

      <div class="col-md-6">
          <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $tender->title }}">

          @error('title')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
  </div> --}}

  <div class="form-group row">
      <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

      <div class="col-md-6">
         <textarea class="form-control @error('description') is-invalid @enderror" rows="8" id="description" name="description" style="resize:none">{{ $tender->description }}</textarea>
          @error('description')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          <div class="mt-3">
            <button id="submit" class="btn btn-primary" >Submit</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='/tenders'">
                Cancel
            </button>
          </div>
      </div>
  </div>
