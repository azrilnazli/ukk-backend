<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#tenderSubmission">
    <i class="fas fa-search"></i> Proposal
</button>
<!-- Modal -->
<div class="modal fade" id="tenderSubmission" tabindex="-1" role="dialog" aria-labelledby="tenderSubmissionLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5>Proposal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @include('pitching.partials.tender_submission', ['tenderSubmission' => $tenderSubmission ])
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        </div>

