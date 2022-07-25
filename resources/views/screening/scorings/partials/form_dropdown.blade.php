<div class="p-2">
    {{ $key }}.
</div>
<div class="p-2">
    {!! $title !!}
    @error($name)
        <input  type="hidden" class="form-control @error('storyline') is-invalid @enderror"  />
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="ml-auto p-2">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text">SCORE</label>
        </div>

        <select
            id="form_{{ $name }}"
            name="{{ $name }}"
            class="custom-select  @error($name) is-invalid @enderror"
            >
            <option>Choose...</option>
            @for($i=$min; $i<=$max; $i++)
                <option
                    value={{ $i }}
                    @if ( old($name, !empty($screeningScoring) ? $screeningScoring->$name : '-1' ) == $i ) selected @endif
                >{{ $i }}</option>
            @endfor
        </select>
    </div>
</div>
