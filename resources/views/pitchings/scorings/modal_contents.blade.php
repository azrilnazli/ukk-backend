<!-- Button trigger modal -->
  <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#exampleModal">
    <i class="fas fa-search"></i> Proposal 
  </button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
        <h5>Proposal Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          @include('JSPD.scorings.proposal', ['tenderSubmission' => $tenderSubmission ])
     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>