@include('pitching.scorings.partials.form_idea', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
@include('pitching.scorings.partials.form_kandungan', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
@include('pitching.scorings.partials.form_comment', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
<div class="col-6"><hr /></div>
@include('pitching.scorings.partials.form_scores', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
<div class="col-6"><hr /></div>
@include('pitching.scorings.partials.form_comply', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))

