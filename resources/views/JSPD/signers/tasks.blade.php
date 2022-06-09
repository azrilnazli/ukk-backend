
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="route('signers.index')">{{ __('Proposal Signers') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal List</li>
    </ol>
</nav>
@stop

@section('content')

{{-- <form method="GET"  action="{{ route('signers.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-5">
      <input required type="text" name="query" class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form> --}}

<div class="card card-dark mt-3">

    <div class="card-header clearfix">
      <h3 class="card-title">Total Proposals ( {{ $proposals->total() }} )</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">@sortablelink('id', 'ID')</th>

                <th width="*">Company</th>

                <th width="*">@sortablelink('tender.tender_category', 'Category')</th>

                <th width="*" class="text-center">@sortablelink('tender.programme_code', 'Programme Code')</th>

                {{-- <th width="*" class="text-center">Penanda</th>
                <th width="*" class="text-center">Urusetia</th> --}}
                {{-- <th width="*">Added by</th> --}}
                <th width="12%" class="text-center"><span class="badge badge-dark">Actions</span></th>
            </thead>

            <tbody>
                @foreach($proposals as $row)

                @if(isset($row->tender_submission->user))

                <tr>
                    <td><h1 class="badge badge-dark">{{$row->tender_submission->id }}</h1></td>
                    <td> @if(isset( $row->tender_submission->user->company))<span class="badge badge-warning">{{  $row->tender_submission->user->company->id }}</span> {{  $row->tender_submission->user->company->name }}@endif</td>
                    <td>{{ $row->tender_submission->tender->type }} - {{ $row->tender_submission->tender->tender_category }}</td>
                    <td class="text-center">{{ $row->tender_submission->tender->programme_code }}</td>
                    {{-- <td class="text-center">{{ $row->signers->count() }}</td>
                    <td class="text-center">{{ $row->urusetia->count() }}</td> --}}
                    <td class="text-center">
                      <a class="btn btn-success btn-sm" href="{{ route('signers.show', $row->tender_submission->id ) }}">
                          <i class="fas fa-user"></i>
                      </a>

                    </td>
                </tr>

                @endif
                @endforeach
            </tbody>

        </table>

    </div>

    </div><!-- /.card-body -->

    <div class="card-footer clearfix">
      <div class="card-tools">

        {{ $proposals->appends(Request::all())->links() }}
      </div>
    </div>


  </div>
  <!-- /.card -->
@stop
