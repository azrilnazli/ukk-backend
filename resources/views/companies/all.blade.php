
@extends('layouts.master')

@section('title', 'Company Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/companies">{{ __('Company Management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Company List</li>
    </ol>
</nav>
@stop

@section('content')


<div class="card card-dark">
    <div class="card-header clearfix">
      <h3 class="card-title">List of companies</h3>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>
                <th width="5%">@sortablelink('id', 'ID')</th>
                <th width="20%">@sortablelink('name','Company Name')</th>
                <th width="*">@sortablelink('email','E-Mail')</th>
                <th width="*">Status</th>
                <th width="12%"></th>
            </thead>

            <tbody>
                @foreach($companies as $row)
                <tr>
                    <td><span class="badge badge-dark">{{$row->id }}</span></td>
                    <td>{{ $row->name  }}</td>
                    <td><strong>{{$row->email }}</strong> ~ <span class="small"><em>{{$row->updated_at->diffForHumans()}}</em></span></td>
                    <td>
             
                        @if($row->is_approved == 1 && $row->is_completed == 1 )
                        <span class="badge badge-success">Approved</span>
                        @endif 
                        
                        @if($row->is_rejected == 1  && $row->is_completed == 0 ) 
                        <span class="badge badge-danger">Rejected</span> 
                        @endif
                        
                        @if($row->is_rejected == 1  && $row->is_completed == 1 ) 
                        <span class="badge badge-warning">Resubmission</span> 
                        @endif

                        @if($row->is_rejected == 0 && $row->is_approved == 0 ) 
                          <span class="badge badge-info">Pending</span>
                        @endif
                
                    </td>
                    <td>       
                      <form action="{{ route('companies.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
    
                          
                      </a>
                      <a class="btn btn-success btn-sm" href="{{ route('companies.edit', $row->id) }}">
                          <i class="fas fa-search"></i> VIEW
                          
                      </a>

                          {{-- <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button> --}}

                      </form>
                    </td>

 
                </tr>
                @endforeach
            </tbody>

        </table>
        
    </div>
  
    </div><!-- /.card-body -->
  

  
  
  </div>
  <!-- /.card -->
@stop