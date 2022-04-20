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
<div class="col-lg-12 ">
        <div class="card card-dark">
          
          <div class="card-header clearfix">
            <h3 class="card-title">List of users</h3>

            <div class="card-tools">
              <a class="btn-sm btn-primary " href="{{ route('users.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
            </div>
          </div>
          <!-- /.card-header -->


          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th width="45%">Name</th>
                  <th width="15%">E-Mail</th>
             
                  <th width="25%"></th>
                </tr>
              </thead>


              @foreach($data as $row)

              <tbody>
                <tr>
                  <td>{{ $row->id }}.</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->email }}</td>
        
                  <td>

                    <a class="btn btn-primary btn-sm" href="#">
                        <i class="fas fa-folder">
                        </i>
                        View
                    </a>
                    <a class="btn btn-info btn-sm" href="#">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Edit
                    </a>
                    <a class="btn btn-danger btn-sm" href="#">
                        <i class="fas fa-trash">
                        </i>
                        Delete
                    </a>
                  </td>
                </tr>
              </tbody>
              @endforeach


            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            
            <div class="card-tools">
              {{ $data->links() }}
            </div>
          </div>

        </div>
        <!-- /.card -->

</div>
@stop