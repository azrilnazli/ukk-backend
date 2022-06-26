@foreach($company->user->proposals as $proposal)
<div class="card card-secondary">
    <div class="card-header">
        <strong><span class="badge badge-dark">{{ $proposal->id }}</span>
            @if($proposal->tender->tender_detail)
                [ {{ $proposal->tender->tender_detail->title }} ]
            @endif
            {{ $proposal->tender->programme_category }} - {{ $proposal->tender->programme_code }}</strong>
    </div>
    <div class="card-body">
        <span class="badge badge-dark">THEME</span>
        <p class="lead">{{ $proposal->theme }}</p>
        <hr />
        <span class="badge badge-dark">SYNOPSIS</span>
        <p class="">{{ $proposal->synopsis }}</p>
    </div>
</div>
@endforeach
