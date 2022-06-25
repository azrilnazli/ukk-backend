
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
      <h3 class="card-title">Total Videos ( {{ $data->total() }} )</h3>

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
              <th width="5%">Snapshot</th>
              <th width="30%">Company</th>
              <th width="30%">Details</th>

              <th width="35%"></th>
            </tr>
          </thead>


          @foreach($data as $row)
          @if (  isset($row->user->company) &&  $row->user->company->is_approved == TRUE )
          <tbody>
            <tr>
              <td><span class="badge badge-dark">{{ $row->id }}</span></td>
              <td class="text-center">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('videos.show', $row->id) }}"><img
                        class=""

                        @if($row->processing == 0)
                          style="height:150px"
                          src="{{ Storage::disk('streaming')->url( $row->id . '/thumbnails/poster.jpg')}}?{{rand()}}"
                        @else
                          style="width:100px"
                          src="{{ asset( 'images/loader.gif' )}}"

                        @endif
                        /></a>

                    </li>

                </ul>
              </td>
              <td>
                ID: <span class="badge badge-warning">{{ $row->user->company->id }}</span><br />
                Status: {!! $row->user->company->is_approved ? '<span class="badge badge-success">Approved</span>' : '<span class="badge badge-danger">Rejected</span>' !!}</span><br />
                Company: <strong>{{ $row->user->company->name }}</strong> <br />
                Email: <strong>{{ $row->user->company->email }}</strong> <br />
                Phone: <strong>{{ $row->user->company->phone }}</strong> <br />
              </td>

              <td>
                <span class="lead">{{ $row->tender->channel }} : {{ $row->tender->programme_category }} ( {{ $row->tender->programme_code }} )</span>
                <br />
                <small>

                    Duration: <strong>{{ $row->tender->number_of_episode }} X {{ $row->tender->duration }}'</strong> <br />

                    Updated:  <strong>{{ $row->created_at  }}</strong> <i>{{ $row->updated_at->diffForHumans() }}</i> <br />

                    Length:  @if($row->processing == 1) <span style="color:red">still processing</span> @else <strong>{{ \Carbon\CarbonInterval::seconds($row->duration)->cascade()->forHumans() }}</strong> @endif<br />
                    Proccesed in :  @if($row->processing == 1) <span style="color:red">still processing</span> @else <strong>{{ \Carbon\CarbonInterval::seconds($row->processing_duration)->cascade()->forHumans() }}</strong> @endif<br />

                </small>
              </td>


              <td class="float-right">

                <form action="{{ route('videos.destroy', $row->id)}}" method="post">
                  @csrf @method('DELETE')
                <a class="btn btn-primary btn-sm " href="{{ route('videos.show', $row->id) }} ">
                    <i class="fas fa-search"></i> VIEW

                </a>
                @role('super-admin')
                <a class="btn btn-success btn-sm  @if($row->processing == 1) disabled  @endif " href="{{ route('videos.edit', $row->id) }}">
                    <i class="fas fa-pencil-alt">
                    </i>

                </a>
                  <button class="btn btn-danger btn-sm   type="submit"><i class="fas fa-trash"></i></button>
                </form>
                @endrole
              </td>
            </tr>
          </tbody>
          @endif
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
