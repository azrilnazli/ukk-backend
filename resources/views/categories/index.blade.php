
@extends('layouts.master')

@section('title', 'Category List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/videos">{{ __('Category Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category List</li>
    </ol>
</nav>
@stop

@section('content')

<div class="card card-dark">
  
    <div class="card-header clearfix">
      <h3 class="card-title">List of Categories</h3>
  
      <div class="card-tools">
        <a class="btn-sm btn-primary " href="{{ route('categories.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
      </div>
  
    </div>
    <!-- /.card-header -->
  
  
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="1%">ID</th>
                <th width="20%">Title</th>
                <th width="*">Added by</th>
                <th width="12%"></th>
  
            </thead>

            <tbody>
                @foreach($data as $row)
                <tr>
                    <td><span class="badge badge-dark">{{$row->id }}</span></td>
                    <td>{{$row->title }}</td>
                    <td><strong>{{$row->user->name }}</strong> on <span class="small"><em>{{ $row->created_at }}</em></span></td>
                    <td>       
                      <form action="{{ route('categories.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
    
                          
                      </a>
                      <a class="btn btn-success btn-sm" href="{{ route('categories.edit', $row->id) }}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          
                      </a>
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
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
        {{ $data->links() }}
      </div>
    </div>
  
  
  </div>
  <!-- /.card -->
@stop