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
@include('screening.scorings.partials.form_scores', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.score_guide')
@include('screening.scorings.partials.form_comply', array('screeningScoring' => $tenderSubmission->screening_scoring ))

<script>
$(document).ready(function(){

    console.log('realtime scoring')

    var forms = ['criteria','storyline','creativity','technical','acting','value_added'];

    var final = [];

    $.each( forms, function( index, value ) {
        //alert( index + ": " + value );
        $("#form_" + value).change(function(){
            var score = parseInt(this.value); ;

            final[index] = score;
            const total = final.reduce((partialSum, a) => partialSum + a, 0);
            //const final_score = Math.round((total/60)*100);
            console.log(total);
            $("#result").html(total);

        });
    });


});
</script>

