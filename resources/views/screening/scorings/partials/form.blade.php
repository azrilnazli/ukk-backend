@include('screening.scorings.partials.form_idea', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.form_kandungan', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.form_comment', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.form_scores', array('screeningScoring' => $tenderSubmission->screening_scoring ))
@include('screening.scorings.partials.score_guide')
@include('screening.scorings.partials.form_comply', array('screeningScoring' => $tenderSubmission->screening_scoring ))

<script>
$(document).ready(function(){

    console.log('realtime scoring')

    var forms = ['storyline','originality','concept','theme','structure','storytelling','objective','props','impact','value_added'];

    var final = [];

    $.each( forms, function( index, value ) {
        //alert( index + ": " + value );
        $("#form_" + value).change(function(){
            var score = parseInt(this.value); ;

            final[index] = score;
            const total = final.reduce((partialSum, a) => partialSum + a, 0);
            console.log(total);
            $("#result").html(total);

        });
    });


});
</script>

