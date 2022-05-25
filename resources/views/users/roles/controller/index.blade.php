@extends('layouts.master')

@section('title', 'Roles Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
      <li class="breadcrumb-item"><a href="/users">{{ __('Users') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Role Management') }}</li>
  </ol>
</nav>
@endsection

@section('content')
<div class="card card-dark mt-3">
  <div class="card-header clearfix">
    <h3 class="card-title">Total Roles ( {{ count($roles) }} )</h3>
    <div class="card-tools">
      <a class="btn-sm btn-primary " href="{{ route('roles.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
    </div>

  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th width="*">Name</th>
            <th width="*">Controller</th>
            <th width="*">Action</th>
            <th width="12%"></th>
          </tr>
        </thead>

        <tbody>
        @foreach($roles as $role)
            @foreach($role->permissions as $key => $permission)
                @php
                $temp = explode("-",$permission->name);
                $controllers[] = $temp[0];
                $actions[] = $temp[1];
                @endphp
            @endforeach
          <tr>
            <td>
                <span class="text-uppercase"><strong>{{ $role->name }}</strong></span>
            </td>
            <td>


                @php
                    $collection = collect($controllers)->unique();
                    $collection->each( function($value,$key) use ($collection){
                        echo ucFirst($value);
                        if ($key === array_key_last($collection->toArray())) {
                            echo '';
                        }else{
                            echo ',';
                        }
                    });
                    unset($controllers);
                @endphp


            </td>

            <td>

                [
                @php
                    $collection = collect($actions)->unique();
                    $collection->each( function($value,$key) use ($collection){
                        echo $value;
                        if ($key === array_key_last($collection->toArray())) {
                            echo '';
                        }else{
                            echo ',';
                        }
                    });
                @endphp
                ]


            </td>

            <td class="float-right">
                <form action="{{ route('roles.destroy', $role)}}" method="post">
                @csrf @method('DELETE')
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
