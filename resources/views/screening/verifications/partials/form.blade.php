@include('screening.verifications.partials.form_idea', array('screeningScoring' => $screeningScoring ))
@include('screening.verifications.partials.form_kandungan', array('screeningScoring' => $screeningScoring ))
@include('screening.verifications.partials.form_comment', array('screeningScoring' => $screeningScoring ))
<div class="col-6"><hr /></div>
@include('screening.verifications.partials.form_scores', array('screeningScoring' => $screeningScoring ))
<div class="col-6"><hr /></div>
@include('screening.verifications.partials.form_comply', array('screeningScoring' => $screeningScoring ))


