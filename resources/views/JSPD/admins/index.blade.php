
@extends('layouts.master')

@section('title', 'Proposal List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposals List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('jspd-admins.search') }}">
  @csrf
  <div class="row ">
    <div class="col">
      <input required type="text" name="query" class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>



<div class="card card-dark mt-3">

    <div class="card-header clearfix">
      <h3 class="card-title">Total Proposals ( {{ $proposals->total() }} )</h3>
    </div>
    <!-- /.card-header -->


    <div class="row">
      <div class="col">
          <div class="card-footer clearfix">
            <div class="card-tools">
              {{ $proposals->appends(Request::all())->links() }}
            </div>
          </div>
      </div>
    </div>


  

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">@sortablelink('id', 'ID')</th>
                <th width="*">Company</th>
                <th width="*">@sortablelink('tender.programme_code', 'Programme Code')</th>
                <th width="*" class="text-center">Owner</th>
                <th width="*" class="text-center">PENANDA</th>
                <th width="*" class="text-center">URUSETIA</th>
                <th width="*" class="text-center">KETUA</th>
                <th width="*" class="text-center">STATUS</th>
                <th width="12%" class="text-center"><span class="badge badge-dark">Actions</span></th>
            </thead>

            <tbody>
                @foreach($proposals as $row)
                @if(isset($row->user->company))
                <tr>
                    <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                    <td>
                        @if(isset($row->user->company))
                        <span class="badge badge-warning">{{ $row->user->company->id }}</span> {{ $row->user->company->name }}
                        <br />
                        <small>{{ $row->tender->type }} - {{ $row->tender->tender_category }}</small>
                        @endif</td>

                    <td>{{ $row->tender->programme_code }}</td>
                    <td class="text-center">
                      {{ optional($row->owner)->name}}
                    </td>
                    <td class="text-center">
                      {{ optional($row->scorings)->count() }}/{{ optional($row->signers)->count() }}
                    </td>
                    <td class="text-center">
                      {{ optional($row->verifications)->count() }}/{{ optional($row->urusetias)->count() }}
                    </td>
                    <td class="text-center">
                      {{ $row->approval ? 1 : 0  }}/1
                    </td>
                    <td class="text-center">

                    @if(( $row->approval ))
                      <span class="badge badge-dark">SELESAI</span>
                    @else
                        @if( optional($row->scorings)->count() == 3 )  
                            @if( optional($row->verifications)->count() == 2 ) 

                                @if(count( $row->approved ) > 1)
                                    <span class="badge badge-success">LULUS</span>
                                @else
                                    <span class="badge badge-danger">GAGAL</span>
                                @endif

                            @else   
                              <span class="badge badge-info">BELUM DISAHKAN</span>
                            @endif
                        @else
                          <span class="badge badge-secondary">BELUM DITANDA</span>
                        @endif
                    @endif
                    </td>
                    <td class="text-center">
                        <form action="{{ route('jspd-admins.destroy', $row->id)}}" method="post">
                        @csrf @method('DELETE')
                          <a class="btn btn-success btn-sm" href="{{ route('jspd-admins.show', $row->id) }}">
                              <i class="fas fa-pencil-alt"></i>
                          </a>
                          @hasrole('super-admin')
                          <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                          @endhasrole
                        </form>
                    </td>
                </tr>

                @endif
                @endforeach
            </tbody>

        </table>

    </div>

    </div><!-- /.card-body -->

    <div class="card-footer clearfix">
      <div class="card-tools">
        {{ $proposals->appends(Request::all())->links() }}
      </div>
    </div>


  </div>
  <!-- /.card -->
@stop
