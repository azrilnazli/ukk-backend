@foreach($company->company_approvals as $approval)
<div class="card card-secondary">
    <div class="card-header">
        @if($approval->tender_detail)
            <strong><span class="badge badge-dark">{{ $approval->tender_detail->id }}</span> {{ $approval->tender_detail->title }}</strong>
        @endif
    </div>
    <div class="card-body">


        <dl class="row">
            <dt class="col-sm-2">Status</dt>
            <dd class="col-sm-6 text-uppercase"><span class="badge badge-dark">{{ $approval->status }}<span></dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-2">Date Request</dt>
            <dd class="col-sm-6">  {{ $approval->created_at }}</dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-2">Last Updated</dt>
            <dd class="col-sm-6">  {{ \Carbon\Carbon::parse($approval->updated_at)->diffForHumans() }}</dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-2">Approved By</dt>
            <dd class="col-sm-6">  {{ optional($approval->user)->name }}</dd>
        </dl>


    </div>
</div>
@endforeach

