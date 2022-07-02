
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
              <th width="5%">Filename</th>
              <th width="15%">Format</th>
              <th width="15%">Length</th>
              <th width="18%">Company</th>
              <th width="*">Date</th>

              <th width="20%" class="text-center">Actions</th>
            </tr>
          </thead>


          @foreach($data as $row)

          <tbody>
            <tr>
              <td><span class="badge badge-dark">{{ $row->id }}</span></td>
              <td>
               {{ $row->original_filename}}
              </td>
              <td>
                <span>  {{ $row->format}}</span>
              </td>

              <td>
                <span>  {{ $row->length}}</span>
              </td>
              <td>
                <span>{{ optional($row->user->company)->name }}</span>
              </td>


              <td>
                {{ $row->created_at }}
              </td>


              <td class="text-center">

                <form action="{{ route('videos.destroy', $row->id)}}" method="post">
                  @csrf @method('DELETE')
                <a class="btn btn-primary btn-sm " href="{{ route('videos.show', $row->id) }} ">
                    <i class="fas fa-search"></i>

                </a>
                @role('super-admin')
                {{-- <a class="btn btn-success btn-sm  @if($row->processing == 1) disabled  @endif " href="{{ route('videos.edit', $row->id) }}">
                    <i class="fas fa-pencil-alt">
                    </i> --}}

                </a>
                  <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm   type="submit"><i class="fas fa-trash"></i></button>
                </form>
                @endrole
              </td>
            </tr>

            @if($row->exception)
            <tr>
                <td colspan="7">

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Error</label>
                    <textarea class="form-control bg-warning" id="exampleFormControlTextarea1" rows="5">{{ $row->exception }}</textarea>
                  </div>
                </td>
            </tr>
            @endif
          </tbody>

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
