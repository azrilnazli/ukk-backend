
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tenders">{{ __('Tender Requirements') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tender Requirement List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('tenders.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-6">
      <input required type="text" name="query" value="{{ old('query', !empty($_GET['query']) ? $_GET['query'] : null ) }}"  class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

<div class="card card-dark mt-3">

    <div class="card-header clearfix">
      <h3 class="card-title">Total ( {{ $tenders->total() }} )</h3>

      <div class="card-tools">
        <a class="btn-sm btn-primary " href="{{ route('tender-requirements.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
      </div>

    </div>
    <!-- /.card-header -->


    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">ID</th>
                <th>Title</th>
                <th>Module</th>

                {{-- <th width="*">Added by</th> --}}
                @role('super-admin')
                <th width="12%"><span class="badge badge-dark">Actions</span></th>
                @endrole
            </thead>

            <tbody>
                @foreach($tenders as $row)

                <tr>
                    <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                    <td>{{$row->title }}</td>
                    <td>{{$row->module }}</td>
                    @role('super-admin')
                    <td>
                      <form action="{{ route('tender-requirements.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
                      <a class="btn btn-success btn-sm" href="{{ route('tender-requirements.edit', $row->id) }}">
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
        {{ $tenders->links() }}
      </div>
    </div>


  </div>
  <!-- /.card -->
@stop
