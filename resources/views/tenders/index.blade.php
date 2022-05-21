
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/tenders">{{ __('Tender Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tender List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('tenders.search') }}">
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
      <h3 class="card-title">List of tenders</h3>

      <div class="card-tools">
        <a class="btn-sm btn-primary " href="{{ route('tenders.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
      </div>

    </div>
    <!-- /.card-header -->


    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">ID</th>
                <th>Channel</th>
                <th>Type</th>

                <th>Category</th>
                <th>Code</th>
                <th>Duration</th>
                <th>Episode</th>
                <th>Language</th>

                {{-- <th width="*">Added by</th> --}}
                @role('super-admin')
                <th width="12%"><span class="badge badge-dark">Actions</span></th>
                @endrole
            </thead>

            <tbody>
                @foreach($tenders as $row)

                <tr>
                    <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                    <td>{{$row->channel }}</td>
                    <td>{{$row->type }}</td>

                    <td>{{$row->tender_category }}</td>
                    <td>{{$row->programme_code }}</td>
                    <td>{{$row->duration }}</td>
                    <td>{{$row->number_of_episode }}</td>
                    <td>
                      @foreach( $row->languages as $lang )
                      <span class="badge badge-warning">{{$lang}}</span>
                      @endforeach

                    </td>
                    @role('super-admin')
                    <td>
                      <form action="{{ route('tenders.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
                      <a class="btn btn-success btn-sm" href="{{ route('tenders.edit', $row->id) }}">
                          <i class="fas fa-pencil-alt"></i>
                      </a>
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                    @endrole
                </tr>

                <tr>
                  <td colspan=9>
                    <div class="alert alert-light" role="alert">
                    {!! nl2br($row->description) !!}
                    </div>
                  </td>
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
