@include('screening.scorings.partials.form_idea', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.form_kandungan', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.form_comment', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-6"><hr /></div>
@include('screening.scorings.partials.form_scores', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-6"><hr /></div>
@include('screening.scorings.partials.form_comply', array('screeningScoring' => $tenderSubmission->screening_scoring ))

