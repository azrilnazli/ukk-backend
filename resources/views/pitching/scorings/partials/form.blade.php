@include('pitching.scorings.partials.form_idea', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
@include('pitching.scorings.partials.form_kandungan', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))
@include('pitching.scorings.partials.form_comment', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))

<table class="table table-bordered col-8">
    <tr>
        <td class="bg-danger text-center">GAGAL</td>
        <td class="bg-warning text-center">BIASA</td>
        <td style="background-color:yellow" class="text-center">SEDERHANA BAIK</td>
        <td class="bg-success text-center">BAIK</td>
        <td class="bg-success text-center">SANGAT BAIK</td>
    </tr>
    <tr>
        <td class="text-center">0-79</td>
        <td class="text-center">80-85</td>
        <td class="text-center">86-90</td>
        <td class="text-center">91-95</td>
        <td class="text-center">96-100</td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-center" colspan=2>DISYORKAN</td>
    </tr>
</table>

@include('pitching.scorings.partials.form_scores', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))

@include('pitching.scorings.partials.form_comply', array('pitchingScoring' => $tenderSubmission->pitching_scoring ))

