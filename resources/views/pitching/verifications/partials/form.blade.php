@include('pitching.scorings.partials.form_idea', array('pitchingScoring' => $pitchingScoring ))
@include('pitching.scorings.partials.form_kandungan', array('pitchingScoring' => $pitchingScoring ))
@include('pitching.scorings.partials.form_comment', array('pitchingScoring' => $pitchingScoring ))
<div class="col-6"><hr /></div>
@include('pitching.scorings.partials.form_scores', array('pitchingScoring' => $pitchingScoring ))
<div class="col-6"><hr /></div>
@include('pitching.scorings.partials.form_comply', array('pitchingScoring' => $pitchingScoring ))

