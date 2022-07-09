@include('pitching.scorings.partials.form_idea', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
@include('pitching.scorings.partials.form_kandungan', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
@include('pitching.scorings.partials.form_comment', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
<div class="col-6"><hr /></div>
<div class="d-flex col-6">

    <div class="p-2">

    </div>
    <div class="p-2">

    </div>

    @if(!empty($pitchingScoring))
    <div class="ml-auto p-2">
        <h1>JUMLAH : <span class="badge badge-dark">65%</span></h1>
    </div>
    @endif
</div>

<div class="col-6"><hr /></div>
@include('pitching.scorings.partials.form_comply', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))

