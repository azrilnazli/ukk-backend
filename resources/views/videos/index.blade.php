
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
      <h3 class="card-title">List of Videos</h3>
  
      <div class="card-tools">
        <a class="btn-sm btn-primary " href="{{ route('videos.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
      </div>
  
    </div>
    <!-- /.card-header -->
  
  
    <div class="card-body p-0">
  
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="2%">ID</th>
              <th width="5%">Landscape</th>
              <th width="5%">Portrait</th>
              <th width="40%">Title</th>
      
              <th width="25%"></th>
            </tr>
          </thead>
  
  
          @foreach($data as $row)
  
          <tbody>
            <tr>
              <td><span class="badge badge-dark">{{ $row->id }}</span></td>
              <td class="text-center">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <img 
                        class="" 
                        
                        @if($row->processing == 0)
                        style="height:150px"
                        src="{{ Storage::disk('streaming')->url( $row->id . '/thumbnails/poster.jpg')}}?{{rand()}}"
                        @else 
                        style="width:100px"
                        src="{{ asset( 'images/loader.gif' )}}"
                       
                        @endif
                        />
                      
                    </li>
          
                </ul>
              </td>
              <td class="text-center">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <img 
                        class="" 
                        
                        @if($row->processing == 0)
                        style="height:150px"
                        src="{{ Storage::disk('streaming')->url( $row->id . '/thumbnails/potrait.jpg')}}?{{rand()}}"
                        @else 
                        style="width:100px"
                        src="{{ asset( 'images/loader.gif' )}}"
                       
                        @endif
                        />
                      
                    </li>
          
                </ul>
              </td>

              <td>
                <span class="lead">{{ $row->title }}</span>
                <br />
                <small>
                    Category <strong>{{ $row->category->title }}</strong> <br />
                    Created by <strong>{{ $row->user->name }}</strong> <br />
                    Date :  <strong>{{ $row->created_at }}</strong> <br />
                    Duration:  @if($row->processing == 1) <span style="color:red">still processing</span> @else <strong>{{ \Carbon\CarbonInterval::seconds($row->duration)->cascade()->forHumans() }}</strong> @endif<br />  
                    Proccesed in :  @if($row->processing == 1) <span style="color:red">still processing</span> @else <strong>{{ \Carbon\CarbonInterval::seconds($row->processing_duration)->cascade()->forHumans() }}</strong> @endif<br />
                   
                </small>
              </td>
     
     
              <td class="float-right">
                
                <form action="{{ route('videos.destroy', $row->id)}}" method="post">
                  @csrf @method('DELETE')
                <a class="btn btn-primary btn-sm " href="{{ route('videos.show', $row->id) }} ">
                    <i class="fas fa-info">
                    </i>
                    
                </a>
                <a class="btn btn-success btn-sm  @if($row->processing == 1) disabled  @endif " href="{{ route('videos.edit', $row->id) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                    
                </a>
                  <button class="btn btn-danger btn-sm   type="submit"><i class="fas fa-trash"></i></button>
                </form>
              </td>            
            </tr>
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