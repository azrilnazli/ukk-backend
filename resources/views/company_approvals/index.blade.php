
@extends('layouts.master')

@section('title', 'Company Approval List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('company-approvals.index')}}">{{ __('Company Approval') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contents List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('company-approvals.search') }}">
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
      <h3 class="card-title">Total ( {{ $companyApprovals->total() }} )</h3>

      {{-- <div class="card-tools">
        <a class="btn-sm btn-primary " href="{{ route('company-approvals.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
      </div> --}}

    </div>
    <!-- /.card-header -->


    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">@sortablelink('id','ID')</th>
                <th>@sortablelink('company.name','Company Name')</th>
                <th>@sortablelink('tender_detail.title','Tender')</th>
                <th>@sortablelink('status','Status')</th>
                <th width="*">Approved by</th>
                @role('super-admin')
                <th width="12%"><span class="badge badge-dark">Actions</span></th>
                @endrole
            </thead>

            <tbody>
                @foreach($companyApprovals as $row)

                <tr>
                    <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                    <td>
                        <span class='badge badge-dark'> {{ optional($row->company)->id }}</span>
                        {{ optional($row->company)->name }}
                    </td>
                    <td>
                        <span class='badge badge-dark'> {{ optional($row->tender_detail)->id }}</span>
                        {{ optional($row->tender_detail)->title }}
                    </td>
                    <td class='text-uppercase'><span class='badge badge-dark'>{{ $row->status }}</span></td>
                    <td>{!!
                        $row->user_id ?
                            "<span class='badge badge-dark'>". $row->user->name ."</span>"
                            :
                            "<span class='badge badge-dark'>nobody</span>"
                    !!}</td>
                    @role('super-admin')
                    <td>
                      <form action="{{ route('company-approvals.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
                      <a class="btn btn-success btn-sm" href="{{ route('company-approvals.edit', $row->id) }}">
                          <i class="fas fa-pencil-alt"></i>
                      </a>
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                    @endrole
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    </div><!-- /.card-body -->

    <div class="card-footer clearfix">
      <div class="card-tools">
        {{ $companyApprovals->links() }}
      </div>
    </div>


  </div>
  <!-- /.card -->
@stop
