
@include('screening.scorings.partials.form_kriteria', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_kandungan', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_value_added', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_need_statement', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_suitable', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_pematuhan', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_comment', array('screeningScoring' => $screeningScoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_scores', array('screeningScoring' => $screeningScoring ))
@include('screening.scorings.partials.score_guide')
@include('screening.scorings.partials.form_comply', array('screeningScoring' => $screeningScoring ))

