<div class="d-flex col-8 mt-5 mb-5">

    <div class="p-2">

    </div>
    <div class="p-2">

    </div>

    @if(!empty($pitchingScoring))

    <div class="ml-auto p-2">
        <h1>JUMLAH : <span class="badge badge-dark">{{ $pitchingScoring->total_score }}%</span></h1>
    </div>
    @else

    <div class="ml-auto p-2">
        <h1>JUMLAH : <span class="badge badge-dark"><span id="result">0</span>%</span></h1>
    </div>

    @endif
</div>
