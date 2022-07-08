@include('pitching.scorings.partials.form_idea')
@include('pitching.scorings.partials.form_kandungan')
@include('pitching.scorings.partials.form_comment')
<div class="col-6"><hr /></div>
<div class="d-flex col-6">

    <div class="p-2">

    </div>
    <div class="p-2">

    </div>
    <div class="ml-auto p-2">
        <h1>JUMLAH : <span class="badge badge-dark">65%</span></h1>
    </div>
</div>

<div class="col-6"><hr /></div>
<div class="d-flex col-6">

    <div class="p-3 d-flex align-items-center bg-warning">
           <input
              class=" @error('is_comply') is-invalid @enderror"
              type="checkbox"
              name="is_comply"
              value=1
              {{-- @if(old('is_comply',  optional($data)->is_comply) == 1) checked @endif  --}}
              />
              @error('is_comply')
              <input  type="hidden" class="form-control @error('is_comply') is-invalid @enderror"  />
              <span class="p-3 invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror

    </div>

    <div class="ml-auto p-2 d-flex align-items-center bg-warning">
            <span>Dengan ini saya mengaku keputusan pemarkahan yang telah dibuat adalah sahih dan muktamad</span>
    </div>
</div>

<div class="d-flex col-6 ">
    <div class="col bg-dark">
        PENANDA :

        <strong>{{ auth()->user()->name }}  ({{ auth()->user()->email }})<br /></strong>

        {{-- {{ \Carbon\Carbon::parse( optional($data)->created_at ? optional($data)->created_at : date('Y-m-d H:i:s'))->format('d/m/Y H:i:s')}} --}}
    </div>
</div>

