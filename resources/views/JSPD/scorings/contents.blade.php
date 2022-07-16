@if(!empty($scorings))
<nav>
    <div class="nav nav-tabs " id="nav-tab" role="tablist">
      {{-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab">SUMMARY</a> --}}
      @foreach($scorings as $key => $score )
        <a class="nav-item nav-link text-uppercase @if($key ==0) show active @endif" id="nav-scoring-tab" data-toggle="tab" href="#score_{{ $score->id }}" role="tab">{{ $score->user ? $score->user->name : null }}</a>
      @endforeach

    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    {{-- <div class="tab-pane fade show active p-2" id="nav-home" role="tabpanel">
        @include('JSPD.scorings.summary')
    </div> --}}
    @foreach($scorings as $key => $score )
      <div  class="tab-pane fade p-2 @if($key ==0) show active @endif" id="score_{{ $score->id }}" role="tabpanel">
        @include('JSPD.scorings.form_verify', ['data' => $score])
      </div>
    @endforeach
</div>
@endif
