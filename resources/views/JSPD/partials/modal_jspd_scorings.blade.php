<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#jspdScoring">
    <i class="fas fa-search"></i> JSPD Score
</button>
<!-- Modal -->
<div class="modal fade" id="jspdScoring" tabindex="-1" role="dialog" aria-labelledby="jspdScoringLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header bg-dark">
            <h5>JSPD Scoring</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body bg-light">
            @include('JSPD.scorings.contents', array('scorings' => $tenderSubmission->scorings) )
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

