<div class="d-flex">
    <div class="p-2">
        Proposal by {{ $tenderSubmission->user->company->name }}
        @include('pitching.partials.modal_tender_submission')
        @include('pitching.partials.modal_company')
        @include('pitching.partials.modal_jspd_scorings')
    </div>

    <div class="ml-auto p-2">
        PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
        TENDER : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->tender_detail->title }}</span>
        PROGRAMME :  <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->programme_category }}  - {{ $tenderSubmission->tender->programme_code }}</span>
        CHANNEL : <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->channel }}</span>
    </div>
</div>
