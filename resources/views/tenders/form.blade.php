


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
                                        !empty($tender) ? $tender->tender_detail_id : null
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


        <div class="form-group row">
            <label for="programme_category" class="col-md-4 col-form-label text-md-right">{{ __('Programme Category') }}</label>

            <div class="col-md-3">
                <input
                    id="programme_category"
                    type="text"
                    class="form-control
                    @error('programme_category') is-invalid @enderror"
                    name="programme_category"
                    value="{{ old('programme_category', !empty($tender) ? $tender->programme_category : null ) }}"
                    required
                />

                @error('programme_category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="programme_code" class="col-md-4 col-form-label text-md-right">{{ __('Programme Code') }}</label>

            <div class="col-md-3">
                <input
                    id="programme_code"
                    type="text"
                    class="form-control
                    @error('programme_code') is-invalid @enderror"
                    name="programme_code"
                    value="{{ old('programme_code', !empty($tender) ? $tender->programme_code : null ) }}"
                    required
                />

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
                <input
                    id="number_of_episode"
                    type="text"
                    class="form-control
                    @error('number_of_episode') is-invalid @enderror"
                    name="number_of_episode"
                    value="{{ old('number_of_episode', !empty($tender) ? $tender->number_of_episode : null ) }}"
                    required
                />

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
                <input
                    id="duration"
                    type="text"
                    class="form-control
                    @error('duration') is-invalid @enderror"
                    name="duration"
                    value="{{ old('duration', !empty($tender) ? $tender->duration : null ) }}"
                    required
                />

                @error('duration')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>



        <div class="form-group row">
            <label for="proposal_text" class="col-md-4 col-form-label text-md-right">{{ __('Languages') }}</label>

            <div class="col-md-6 mt-2">
                @if($languages)
                    @foreach($languages as $language)
                    <div class="form-check">
                        <input
                            value="{{ $language->id }}"
                            name="languages[]"
                            class="form-check-input"
                            @if(!empty($tender))
                                @if( $tender->languages->pluck('id')->contains($language->id)) checked @endif
                            @endif
                            type="checkbox"  />
                        <label class="form-check-label text-muted">
                            {{ ucWords(str_replace('-',' ',$language->title)) }}
                        </label>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

            <div class="col-md-6">
                <textarea
                    class="form-control
                    @error('description') is-invalid @enderror"
                    rows="8"
                    id="description"
                    name="description"
                    style="resize:none"
                    required
                    autocomplete="description">{{ old('description', !empty($tender) ? $tender->description : null ) }}</textarea>
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
