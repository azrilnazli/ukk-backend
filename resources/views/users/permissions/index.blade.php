@extends('layouts.master')

@section('title', 'Roles Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
      <li class="breadcrumb-item"><a href="/users">{{ __('Users') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Permission Management') }}</li>
  </ol>
</nav>
@endsection

@section('content')
<div class="card card-dark mt-3">
  <div class="card-header clearfix">
    <h3 class="card-title">Total Permissions ( {{ count($permissions) }} )</h3>
    {{-- <div class="card-tools">
      <a class="btn-sm btn-primary " href="{{ route('roles.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
    </div> --}}

  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th width="5%">ID</th>
            <th width="50%">Name</th>
            @foreach($roles as $role)
              <th class="text-center" width="{{ round((45/count($roles))) }}%"><span class="text-uppercase">{{ $role->name }}</span></th>
            @endforeach
 
      
          </tr>
        </thead>

        <tbody>
        @foreach($permissions as $key => $permission)
          <tr>
            <td>
              <span class="badge badge-dark">{{ $key }}</span>
          </td>
            <td >
                <span class="text-uppercase">{{ $permission }}</span>
            </td>
  
            @foreach($roles as $role)
              <td class="text-center"><span >
               @php 
                  $role_permissions = $role->permissions->pluck('name')->toArray();
               @endphp

               @if(in_array($permission, $role_permissions))
               <i class="fas fa-check"></i>
               @else 
               <small><i class="fas fa-circle text-muted"></i></small>
               @endif
              </span></td>
            @endforeach

        @endforeach


      </tbody>
      </table>
    </div>
  </div>
 </div>
<!-- /.card -->
@endsection
