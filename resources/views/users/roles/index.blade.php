@extends('layouts.master')

@section('title', 'Roles Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('user-roles.index') }}">{{ __('Roles') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Roles Management') }}</li>
  </ol>
</nav>
@endsection

@section('content')
<div class="card card-dark mt-3">
  <div class="card-header clearfix">
    <h3 class="card-title">Total Roles ( {{ count($roles) }} )</h3>
    <div class="card-tools">
      <a class="btn-sm btn-primary " href="{{ route('user-roles.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
    </div>

  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th width="5%">ID</th>
            <th width="*">Name</th>
            <th width="10%"></th>
          </tr>
        </thead>

        <tbody>
        @foreach($roles as $role)
          <tr>
            <td>
                <span class="badge badge-dark">{{ $role->id }}</span>
            </td>
            <td>
                <span>{{ $role->name }}</span>
            </td>

            <td>
              <form action="{{ route('user-roles.destroy', $role->id)}}" method="post">
                @csrf
                @method('delete')
                <a class="btn btn-success btn-sm" href="{{ route('user-roles.edit', $role->name) }}"><i class="fas fa-pencil-alt"></i></a>
                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
              </form>
            </td>

          </tr>
        @endforeach


      </tbody>
      </table>
    </div>
  </div>
 </div>
<!-- /.card -->
@endsection
