
<div class="d-flex">
    <div class="p-2">
        @hasanyrole('ketua-urusetia|screening-urusetia')
        <div class="row mb-2 ml-1"><small>
            PROPOSAL BY :

            <span class="badge badge-warning text-uppercase"> <span class="badge badge-dark text-uppercase">{{  $tenderSubmission->user->company->id }}</span>     {{  $tenderSubmission->user->company->name }}</span>
        </small></div>
        @endhasanyrole
        <div class="row mb-2 ml-1">

                @include('screening.partials.modal_tender_submission')
                &nbsp;
            @hasanyrole('ketua-urusetia|screening-urusetia')
                @include('screening.partials.modal_company')
                &nbsp;
                @include('screening.partials.modal_jspd_scorings')
            @endhasanyrole
        </div>
    </div>

    <div class="ml-auto p-2"><small>
        PROPOSAL ID : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->id}}</span>
        TENDER : <span class="badge badge-warning text-uppercase">{{ $tenderSubmission->tender->tender_detail->title }}</span>
        PROGRAMME :  <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->programme_category }}  - {{ $tenderSubmission->tender->programme_code }}</span>
        CHANNEL : <span class="badge badge-warning text-uppercase ">{{ $tenderSubmission->tender->channel }}</span>
    </small></div>
</div>
