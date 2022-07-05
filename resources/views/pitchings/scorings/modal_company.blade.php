<!-- Button trigger modal -->
  <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#company_modal">
    <i class="fas fa-search"></i> Company 
  </button>
<!-- Modal -->
<div class="modal fade" id="company_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable " role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
        <h5>Company Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="{{ route('scorings.company', $tenderSubmission->user->company->id) }}" allowfullscreen></iframe>
          </div>
        </div>
         
     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>