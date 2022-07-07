<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#company">
    <i class="fas fa-search"></i> Company
</button>
<!-- Modal -->
<div class="modal fade" id="company" tabindex="-1" role="dialog" aria-labelledby="companyLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header bg-dark">
            <h5>Company Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body bg-light">
            @include('pitching.partials.company', ['company' => $tenderSubmission->company ])
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

