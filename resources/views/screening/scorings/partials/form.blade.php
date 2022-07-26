@include('screening.scorings.partials.form_kriteria', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_kandungan', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_value_added', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_need_statement', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_suitable', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_pematuhan', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
@include('screening.scorings.partials.form_comment', array('screeningScoring' => $tenderSubmission->screening_scoring ))
<div class="col-8"><hr /></div>
{{-- @include('screening.scorings.partials.form_scores', array('screeningScoring' => $tenderSubmission->screening_scoring )) --}}
@include('screening.scorings.partials.score_guide')
@include('screening.scorings.partials.form_comply', array('screeningScoring' => $tenderSubmission->screening_scoring ))


