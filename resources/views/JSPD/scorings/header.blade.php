<div class="card-title">
    Proposal by {{ $tenderSubmission->company->name }}
    @include('JSPD.scorings.modal_tender_submission')
    &nbsp;
    @include('JSPD.scorings.modal_company')
</div>
<div class="card-item text-right bg-dark p-2">
    PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
    CATEGORY :    <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->type }}</span> - {{ $tenderSubmission->tender->programme_category }}</span>
    CODE :        <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->programme_code }}</span>
    CHANNEL :     <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->channel }}</span>
</div>
