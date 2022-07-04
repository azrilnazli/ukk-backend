
@extends('layouts.master')

@section('title', 'Company Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/companies">{{ __('Company Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Company List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('companies.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-5">
      <input required type="text" name="query" value="{{ old('query', !empty($_GET['query']) ? $_GET['query'] : null ) }}"  class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

    <div class="card-tools mt-3">
      {{-- {{ $data->links() }} --}}
      {!! $data->appends(\Request::except('page'))->render() !!}
    </div>


<div class="card card-dark mt-3">

    <div class="card-header clearfix">
      <h3 class="card-title">Total Companies ( {{ $data->total() }} )</h3>
    </div>



    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">@sortablelink('id', 'ID')</th>
                <th width="*">@sortablelink('name','Company Name')</th>
                <th class="text-center" width="12%">Proposals</th>
                <th width="8%" class="text-center">Videos</th>
                <th width="8%" class="text-center">Actions</th>

            </thead>

            <tbody>
                @foreach($data as $row)
                <tr>
                    <td><span class="badge badge-dark">{{$row->id }}</span></td>
                    <td>
                        <span class="lead">{{ $row->name  }}</span>
                        <br />
                        <span class="small">registered : <em>{{$row->created_at->diffForHumans()}}</em></span>
                    </td>
                    <td class="text-center">{{ $row->user ? $row->user->proposals->count() : 0 }}</td>
                    <td class="text-center">{{ $row->videos ? $row->videos->count() : 0 }}</td>

                    <td class="text-center">
                      <form action="{{ route('companies.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
                      </a>
                      <a class="btn btn-success btn-sm" href="{{ route('companies.show', $row->id) }}">
                          <i class="fas fa-search"></i>

                      </a>
                        @hasrole('super-admin')
                          <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                        @endhasrole
                      </form>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    </div><!-- /.card-body -->

    <div class="card-footer clearfix">
      <div class="card-tools">
        {{-- {{ $data->links() }} --}}
        {!! $data->appends(\Request::except('page'))->render() !!}
      </div>
    </div>


  </div>
  <!-- /.card -->
@stop
