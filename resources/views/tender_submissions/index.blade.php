
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="route('tender_submissions.index')">{{ __('Tender Submission') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tender List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('tender_submissions.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-3">
      <input required type="text" name="query" class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

<div class="card card-dark mt-3">
  
    <div class="card-header clearfix">
      <h3 class="card-title">List of Proposals</h3>
    </div>
    <!-- /.card-header -->
  
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">ID</th>
     
                <th width="*">Company</th>
                
                <th width="*">Category</th>

                <th width="*">Programme Code</th>

                <th>PDF</th>
                <th>VIDEO</th>
                {{-- <th width="*">Added by</th> --}}
                <th width="12%" class="text-center"><span class="badge badge-dark">Actions</span></th>
            </thead>

            <tbody>
                @foreach($proposals as $row)
       
                <tr>
                    <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                    <td><span class="badge badge-warning">{{ $row->user->company->id }}</span> {{ $row->user->company->name }}</td>
                    <td>{{ $row->tender->type }} - {{ $row->tender->tender_category }}</td>
                    <td>{{ $row->tender->programme_code }}</td>
                    <td>{!! $row->is_pdf ? '<span class="text-success"><i class="fas fa-check"></i></span>' : '<span class="text-danger"><i class="fas fa-times"></span></i>' !!} </td>     
                    <td>{!! $row->video->is_ready ? '<span class="text-success"><i class="fas fa-check"></i></span>' : '<span class="text-danger"><i class="fas fa-times"></span></i>' !!} </td>     
                     
                    <td class="text-center">
                      {{-- <a class="btn btn-success btn-sm" href="{{ route('tender_submissions.show', $row->id) }}">
                          <i class="fas fa-pencil-alt"></i>
                      </a> --}}

                    </td>
                </tr>
                
           
                @endforeach
            </tbody>

        </table>
        
    </div>
  
    </div><!-- /.card-body -->
  
    <div class="card-footer clearfix">
      <div class="card-tools">
        {{ $proposals->links() }}
      </div>
    </div>
  
  
  </div>
  <!-- /.card -->
@stop