<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
    <div class="col-md-6">
        <input 
            id="title" 
            type="text" 
            class="form-control 
            @error('title') is-invalid @enderror" 
            name="title" 
            value="{{ old('title', !empty($data) ? $data->title : null ) }}"
            >

        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="date_start" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>
    <div class="col-md-6">
        <input 
            id="date_start" 
            type="date" 
            class="form-control 
            @error('date_start') is-invalid @enderror" 
            name="date_start" 
            value="{{ old('date_start', !empty($data) ? $data->date_start : null ) }}"
            >

        @error('date_start')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="date_end" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>
    <div class="col-md-6">
        <input 
            id="date_end" 
            type="date" 
            class="form-control 
            @error('date_end') is-invalid @enderror" 
            name="date_end" 
            value="{{ old('date_end', !empty($data) ? $data->date_end : null ) }}"
             >

        @error('date_end')
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
             
            >{{ old('login_text', !empty($data) ? $data->login_text : null ) }}</textarea>
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
             
            >{{ old('dashboard_text', !empty($data) ? $data->dashboard_text : null ) }}</textarea>
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
             
            >{{ old('proposal_text', !empty($data) ? $data->proposal_text : null ) }}</textarea>
        @error('proposal_text')
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