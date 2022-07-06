Proposal by {{ $tenderSubmission->user->company->name }}
@include('pitching.signers.partials.modal')
</div>
<div class="card-item text-right bg-dark p-2">
PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
TENDER : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->tender_detail->title }}</span>
PROGRAMME :  <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->programme_category }}  - {{ $tenderSubmission->tender->programme_code }}</span>
CHANNEL : <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->channel }}</span>
</div>
