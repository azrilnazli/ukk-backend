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

<div class="card card-dark">
  <div class="card-header clearfix">
    <h3 class="card-title">List of Users</h3>
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
            <th width="50%">E-Mail</th>
            <th width="8%">Role</th>
            <th width="12%"></th>
          </tr>
        </thead>

        <tbody>
        @foreach($data as $row)
          <tr>
            <td><span class="badge badge-dark">{{ $row->id }}</span></td>
            <td>{{ $row->email }}</td>
            <td>
            @if(!empty($row->getRoleNames()))
              @foreach($row->getRoleNames() as $v)
                @switch($v)
                  @case('super-admin')
                  <label class="badge badge-danger p-2 text-uppercase ">{{ $v }}</label>
                  @break
                  @case('admin')
                  <label class="badge badge-warning p-2 text-uppercase">{{ $v }}</label>
                  @break
                  @case('user')
                  <label class="badge badge-primary p-2 text-uppercase">{{ $v }}</label>
                  @break
                  @case('subscriber')
                  <label class="badge badge-success p-2 text-uppercase">{{ $v }}</label>
                  @break
                @endswitch       
              @endforeach
            @endif
            </td>

            <td class="float-right">
              <form action="{{ route('users.destroy', $row->id)}}" method="post">
                @csrf @method('DELETE')
              <a class="btn btn-primary btn-sm" href="{{ route('users.show', $row->id) }} ">
                  <i class="fas fa-info">
                  </i>
              </a>
              <a class="btn btn-success btn-sm" href="{{ route('users.edit', $row->id) }}">
                  <i class="fas fa-pencil-alt">
                  </i>
                  
              </a>
                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
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