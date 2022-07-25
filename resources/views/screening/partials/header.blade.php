{{-- <div class="d-flex">
    <div class="p-2">
        Proposal by {{ $tenderSubmission->user->company->name }}
        @include('screening.partials.modal_tender_submission')
        @include('screening.partials.modal_company')
        @include('screening.partials.modal_jspd_scorings')
    </div>

    <div class="ml-auto p-2">
        PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
        TENDER : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->tender_detail->title }}</span>
        PROGRAMME :  <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->programme_category }}  - {{ $tenderSubmission->tender->programme_code }}</span>
        CHANNEL : <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->channel }}</span>
    </div>
</div> --}}

<div class="d-flex">
    <div class="p-2">
        <div class="row mb-2 ml-1"><small>
            PROPOSAL BY :

            <span class="badge badge-warning text-uppercase"> <span class="badge badge-dark text-uppercase">{{  $tenderSubmission->user->company->id }}</span>     {{  $tenderSubmission->user->company->name }}</span>
        </small></div>
        <div class="row mb-2 ml-1">
            @include('screening.partials.modal_tender_submission')
            &nbsp;
            @include('screening.partials.modal_company')
            &nbsp;
            @include('screening.partials.modal_jspd_scorings')
        </div>
    </div>

    <div class="ml-auto p-2"><small>
        PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
        TENDER : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->tender_detail->title }}</span>
        PROGRAMME :  <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->programme_category }}  - {{ $tenderSubmission->tender->programme_code }}</span>
        CHANNEL : <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->channel }}</span>
    </small></div>
</div>
