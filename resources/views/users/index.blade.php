@extends('layouts.master')

@section('title', 'User Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('User Management') }}</li>
  </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('users.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-md-6">
      <input required type="text" name="query" class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

<div class="card card-dark mt-3">
  <div class="card-header clearfix">
    <h3 class="card-title">Total Users ( {{ $data->total() }} )</h3>
    <div class="card-tools">
      <a class="btn-sm btn-primary " href="{{ route('users.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
    </div>

  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th width="2%">ID</th>
            <th width="40%">E-Mail</th>

            <th width="8%">Role</th>
            <th width="12%"></th>
          </tr>
        </thead>

        <tbody>
        @foreach($data as $row)
          <tr>
            <td><span class="badge badge-dark">{{ $row->id }}</span></td>
            <td><strong>{{ $row->email }}</strong>

                @if($row->company)
                    <br />
                    <span class="badge badge-dark">{{ $row->company->name }} - {{ $row->company->phone }}</span>
                @endif
                <br /><small> registered on  {{ $row->created_at }} around {{ $row->created_at->diffForHumans()  }}</small>
            </td>

                <td>
            @if(!empty($row->getRoleNames()))
              @foreach($row->getRoleNames() as $v)
                <span class="badge badge-dark text-uppercase ">{{ $v }}</span>
              @endforeach
            @endif
            </td>

            <td class="float-right">
              <form action="{{ route('users.destroy', $row->id)}}" method="post">
                @csrf @method('DELETE')
              <a class="btn btn-primary btn-sm" href="{{ route('users.show', $row->id) }} ">
                  <i class="fas fa-search">
                  </i>
              </a>
              @role('super-admin')
              <a class="btn btn-success btn-sm" href="{{ route('users.edit', $row->id) }}">
                  <i class="fas fa-pencil-alt">
                  </i>

              </a>
              @endrole


                @role('super-admin')
                    @if(!in_array($row->id,[1,2,3,4]))
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                    @else
                    <button disabled class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                    @endif
                @endrole
              </form>
            </td>
          </tr>


        @endforeach
      </tbody>
      </table>
    </div>

  </div>
  <!-- /.card-body -->
  <div class="card-footer clearfix">

    <div class="card-tools">
      {{ $data->links() }}
    </div>

  </div>

</div>
<!-- /.card -->


@stop
