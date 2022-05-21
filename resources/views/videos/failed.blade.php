
@extends('layouts.master')

@section('title', 'Video List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Video Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Video List</li>
    </ol>
</nav>
@stop

@section('content')

<div class="card card-dark">

    <div class="card-header clearfix">
      <h3 class="card-title">Total Failed Videos ( {{ $data->total() }} )</h3>

      {{-- <div class="card-tools">
        <a class="btn-sm btn-primary " href="{{ route('videos.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
      </div>
   --}}
    </div>
    <!-- /.card-header -->


    <div class="card-body p-0">

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="2%">ID</th>
              <th width="50%">Company</th>
              <th width="50%">Details</th>

              {{-- <th width="25%" class="text-center">Actions</th> --}}
            </tr>
          </thead>


          @foreach($data as $row)
          {{-- @if (  isset($row->user->company) &&  $row->user->company->is_approved == TRUE ) --}}
          <tbody>
            <tr>
              <td><span class="badge badge-dark">{{ $row->id }}</span></td>
              <td>


                  Company ID: <span class="badge badge-warning">{{ $row->user->company->id }}</span><br />
                  Company Status: {!! $row->user->company->is_approved ? '<span class="badge badge-success">Approved</span>' : '<span class="badge badge-danger">Rejected</span>' !!}</span><br />
                  Company Name: <strong>{{ $row->user->company->name }}</strong> <br />
                  Email: <strong>{{ $row->user->company->email }}</strong> <br />
                  Phone: <strong>{{ $row->user->company->phone }}</strong> <br />

              </td>

              <td>
                <span class="lead">{{ $row->tender->channel }} : {{ $row->tender->tender_category }} ( {{ $row->tender->programme_code }} )</span>
                <br />
                <small>

                    Duration: <strong>{{ $row->tender->number_of_episode }} X {{ $row->tender->duration }}'</strong> <br />
                    Language: <strong>{{ implode(',', $row->tender->languages) }}</strong> <br />

                    Date:  <strong>{{ $row->created_at  }}</strong> <i>{{ $row->created_at->diffForHumans() }}</i> <br />

                </small>
              </td>


              {{-- <td class="text-center">

                <form action="{{ route('videos.destroy', $row->id)}}" method="post">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm   type="submit"><i class="fas fa-trash"></i></button>
                </form>
              </td>             --}}
            </tr>
          </tbody>
          {{-- @endif --}}
          @endforeach


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
