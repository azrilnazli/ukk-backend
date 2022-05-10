
@extends('layouts.master')

@section('name', 'Update Company')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/companies">{{ __('Company Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
    </ol>
</nav>
@stop

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  


<div class="card card-secondary">
    <div class="card-header">
      <strong>Profile</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Name</dt>
            <dd class="col-sm-9">{{ $company->name }}</dd>


            <dt class="col-sm-2">Email</dt>
            <dd class="col-sm-9">{{ $company->email }}</dd>

            <dt class="col-sm-2">Phone</dt>
            <dd class="col-sm-9">{{ $company->phone }}</dd>

            <dt class="col-sm-2">Address</dt>
            <dd class="col-sm-9">{{ $company->address }}</dd>

            <dt class="col-sm-2">Postcode</dt>
            <dd class="col-sm-9">{{ $company->postcode }}</dd>

            <dt class="col-sm-2">City</dt>
            <dd class="col-sm-9">{{ $company->city }}</dd>

            <dt class="col-sm-2">State</dt>
            <dd class="col-sm-9">{{ $company->states }}</dd>

        </dl>
    </div>
  </div>


   
<div class="card card-secondary">
    <div class="card-header">
      <strong>Board of Directors</strong>
    </div>
    <div class="card-body">
    {!! nl2br( $company->board_of_directors) !!}
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
      <strong>Experiences</strong>
    </div>
    <div class="card-body">
    {!! nl2br( $company->experiences) !!}
    </div>
</div>


<div class="card card-secondary">
    <div class="card-header">
      <strong>SSM</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->ssm_registration_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->ssm_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_ssm_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#ssm_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  

  <div class="card card-secondary">
    <div class="card-header">
      <strong>MOF</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->mof_registration_number }}</dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-2">eProlehan Status</dt>
            <dd class="col-sm-9">{!! $company->is_mof_active ? 
            '<span class="badge badge-success">Active</span>' 
            : 
            '<span class="badge badge-danger">Expired</span>'
            !!}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->mof_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_mof_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mof_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>FINAS (FP)</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->finas_fp_registration_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->finas_fp_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_finas_fp_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#finas_fp_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>FINAS (DF)</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->finas_fd_registration_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->finas_fd_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_finas_fd_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#finas_fd_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>KKMM (SYNDICATED)</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->kkmm_syndicated_registration_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->kkmm_syndicated_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_kkmm_syndicated_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#kkmm_syndicated_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>KKMM (Swasta)</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->kkmm_swasta_registration_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->kkmm_swasta_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_kkmm_swasta_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#kkmm_swasta_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>Bumiputera Status</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Registration Number</dt>
            <dd class="col-sm-9">{{ $company->bumiputera_registration_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Expiry Date</dt>
            <dd class="col-sm-9">{{ $company->bumiputera_expiry_date }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_bumiputera_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#bumiputera_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>Banking Info</strong>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Account Number</dt>
            <dd class="col-sm-9">{{ $company->bank_account_number }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Statement Start Date</dt>
            <dd class="col-sm-9">{{ $company->bank_statement_date_start }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Statement End Date</dt>
            <dd class="col-sm-9">{{ $company->bank_statement_date_end }}</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_bank_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#bank_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  <div class="card card-secondary">
    <div class="card-header">
      <strong>Credit Facility</strong>
    </div>
    <div class="card-body">

        <dl class="row">
            <dt class="col-sm-2">Document</dt>
            <dd class="col-sm-9">
             {!!$company->is_credit_cert_uploaded ? 
                
                '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#credit_modal">
                    View Document
                </button>' 
                
                : '<span class="text-danger">missing document</span>' !!}
         
            </dd>
        </dl>
    </div>
  </div>

  

    @foreach($documents as $key => $document)
    <!-- Modal -->
    <div class="modal fade" id="{{$document}}_modal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">{{ $document }} Document</h5>
                <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        
                <div style="height:500px" id="{{$document}}_cert"></div>
                <script>PDFObject.embed("/storage/companies/{{$company->id}}/{{$document}}_cert.pdf", "#{{$document}}_cert");</script>
  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     
            </div>
            </div>
        </div>
    </div>
    @endforeach

<form method="POST" id="edit_Company" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card card-secondary " style="background-color:lightblue">
  
    <div class="card-header">
        Administration
    </div><!-- /.card-header -->

    <div class="card-body pl-5 pr-5">
        <label>Previous Conversation </label>
        @foreach($messages as $comment)
        <div class="alert alert-success" role="alert">
            <dl class="row">
                <dt class="col-1"><span class="badge badge-light">{{$comment->user->name }}</span></dt>
                <dd class="col-11">{{$comment->message}}</dd>
            </dl>
            <small><i>{{$comment->created_at->diffForHumans() }}</i></small>
        </div>  
        @endForeach  
    </div>

    <div class="card-body pl-5 pr-5">

        <div class="form-group row">
                 
            <dl class="row">
                <dt class="col-sm-6">Update Status</dt>
                <dd class="col-sm-8">


                    <div class="form-check-inline">
                        <label class="form-check-label">
                          <input value=1 {{ $company->is_approved == 1 ? 'checked' : null }} type="radio" class="form-check-input" name="is_approved">Approve
                        </label>
                      </div>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          <input value=0 {{ $company->is_approved == 0 ? 'checked' : null }} type="radio" class="form-check-input" name="is_approved">Reject
                        </label>
                      </div>
                </dd>
            </dl>
      </div>


          <div class="form-group row">
                  <label>Message to Vendor </label>
                  <textarea class="form-control @error('message') is-invalid @enderror" rows="8" id="message" name="message" style="resize:none"  autocomplete="message"></textarea>
                  @error('message')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="mt-3">
                    <button id="submit" class="btn btn-primary" >Submit</button>
                    
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/companies'">
                        Cancel 
                    </button>
                  </div>
            </div>
              
          
    </div><!-- /.card-body -->
</div><!-- /.card -->
</form>
<script>
    $( document ).ready(function() {
          $( "#submit" ).click(function() {
          //alert( "Handler for .click() called." );
          $("#edit_Company").submit();
        });
    });
    </script>

 
@stop