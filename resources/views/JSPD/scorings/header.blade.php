<div class="card-title">
    Proposal by {{ $tenderSubmission->user->company->name }}
    @include('JSPD.scorings.modal_contents')
    @include('JSPD.scorings.modal_company')
</div>
<div class="card-item text-right">
    <span class="badge badge-warning text-uppercase">PROPOSAL ID</span> : {{ $tenderSubmission->id}}
    <span class="badge badge-warning text-uppercase ">CATEGORY</span> : {{ $tenderSubmission->tender->type }} - {{ $tenderSubmission->tender->programme_category }}
    <span class="badge badge-warning text-uppercase ">CODE</span> : {{ $tenderSubmission->tender->programme_code }}
    <span class="badge badge-warning text-uppercase ">CHANNEL</span> : {{ $tenderSubmission->tender->channel }}
</div>
