@include('pitching.verifications.partials.form_idea', array('pitchingScoring' => $pitchingScoring ))
@include('pitching.verifications.partials.form_kandungan', array('pitchingScoring' => $pitchingScoring ))
@include('pitching.verifications.partials.form_comment', array('pitchingScoring' => $pitchingScoring ))
<div class="col-6"><hr /></div>
@include('pitching.verifications.partials.form_scores', array('pitchingScoring' => $pitchingScoring ))
<div class="col-6"><hr /></div>
@include('pitching.verifications.partials.form_comply', array('pitchingScoring' => $pitchingScoring ))


