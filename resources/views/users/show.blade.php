@extends('layouts.master')

@section('title', 'Create User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('User Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __(ucfirst($user->name)) }}</li>
    </ol>
</nav>
@stop

@section('content')

<!-- Horizontal Form -->
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">User Info</div>
            <div class="card-body">


                {{-- <dl class="row">
                    @foreach($user->toArray() as $key => $value)
                        <dt class="col-sm-4 text-right text-uppercase">{{ str_replace("_", " " , $key) }}</dt>
                        <dd class="col-sm-8 text-left">{{ $value }}</dd>
                    @endforeach
                </dl> --}}
                <dl class="row">
                <dt class="col-sm-4 text-right text-uppercase">user id</dt>
                <dd class="col-sm-8 text-left"><span class="badge badge-warning">{{ $user->id }}</span></dd>

                <dt class="col-sm-4 text-right text-uppercase">user email</dt>
                <dd class="col-sm-8 text-left">{{ $user->email }}</dd>

                <dt class="col-sm-4 text-right text-uppercase">phone</dt>
                <dd class="col-sm-8 text-left">{{ $user->phone }}</dd>
                </dl>

            </div>
            <div class="card-footer text-muted ">Registered <span>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span></div>
        </div>
    </div>
</div>

@if ($user->company)
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">Company Info</div>
            <div class="card-body">


                {{-- <dl class="row">
                    @foreach($user->company->toArray() as $key => $value)
                        <dt class="col-sm-4 text-right text-uppercase">{{ str_replace("_", " " , $key) }}</dt>
                        <dd class="col-sm-8 text-left">{!! $value === 1 ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : $value!!}</dd>
                    @endforeach
                </dl> --}}


                <dl class="row">

                        <dt class="col-sm-4 text-right text-uppercase">company id</dt>
                        <dd class="col-sm-8 text-left"><span class="badge badge-warning"> {{ $user->company->id }}</span></dd>

                        <dt class="col-sm-4 text-right text-uppercase">Is Approved ?</dt>
                        <dd class="col-sm-8 text-left">


                            @if($user->company->is_approved == 1 && $user->company->is_completed == 1 )
                            <span class="badge badge-success">Approved</span>
                            @endif 
                            
                            @if($user->company->is_rejected == 1  && $user->company->is_completed == 0 ) 
                            <span class="badge badge-danger">Rejected</span> 
                            @endif
                            
                            @if($user->company->is_rejected == 1  && $user->company->is_completed == 1 ) 
                            <span class="badge badge-warning">Resubmission</span> 
                            @endif
    
                            @if($user->company->is_rejected == 0 && $user->company->is_approved == 0 ) 
                              <span class="badge badge-info">Pending</span>
                            @endif

                        </dd>

                        <dt class="col-sm-4 text-right text-uppercase">company name</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->name }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company email</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->email }}</dd>

                        <dt class="col-sm-4 text-right text-uppercase">company phone</dt>
                        <dd class="col-sm-8 text-left">{{ $user->company->phone }}</dd>

                </dl>
            </div>
            <div class="card-footer text-muted">Submitted <span>{{ \Carbon\Carbon::parse($user->company->created_at)->diffForHumans() }}</div>
        </div>
    </div>
</div>
@endif


@if($user->proposals)
<div class="row">
    <div class="col">
        <div class="card card-info">
            <div class="card-header">PROPOSAL</div>
            <div class="card-body">


             
               
                <table class="table">
                    <tr>
                        <th width="5%">ID</td>
                        <th>CATEGORY</td>
                        <th>PROGRAMME CODE</td>
                        <th>ATTACHMENTS</th>
                    </tr>
                    @foreach($user->proposals as $proposal)
                    <tr>
                        <td><span class="badge badge-warning">{{$proposal->id}}</span></td>
                        <td>
                            {{$proposal->tender->type}}-{{$proposal->tender->tender_category}}
                            <br />
                            <small>
                            Submitted <span>{{ \Carbon\Carbon::parse($proposal->created_at)->diffForHumans() }}<br />
                            Updated <span>{{ \Carbon\Carbon::parse($proposal->updated_at)->diffForHumans() }}
                            </small>
                        </td>
                        <td>{{$proposal->tender->programme_code}}</td>
                        <td>
                            {!!$proposal->is_pdf_cert_uploaded ?  '<span class="badge badge-dark">PDF</span>' : null !!}
                            @if($proposal->video->is_ready) 
                                <span class="badge badge-dark">VIDEO ( ID:{{ $proposal->video->id }} )</span>
                            @endif     
                        
                        </td>
                    
                    </tr>   
                    @endforeach
                </table>     




             
            </div>
            <div class="card-footer text-muted">Submitted <span>{{ \Carbon\Carbon::parse($user->company->created_at)->diffForHumans() }}</div>
        </div>
    </div>
</div>
@endif


<form id="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@stop
