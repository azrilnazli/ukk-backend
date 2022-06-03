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

<form method="GET"  action="{{ route('users.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-lg-5">
      <input required type="text" name="query" class="form-control" placeholder="Search">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>


<div class="card card-dark mt-3">
  <div class="card-header clearfix">
    <h3 class="card-title">Total Users ( {{ $data->total() }} )</h3>
    <div class="card-tools">
      <a class="btn-sm btn-primary " href="{{ route('users.create') }}" role="button"><i class="fas fa-plus"></i> Create</a>
    </div>

  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th width="2%">ID</th>
            <th width="40%">E-Mail</th>
            <th class="text-center" width="10%">Comments</th>
            <th class="text-center" width="10%">Proposal</th>
            <th width="8%">Role</th>
            <th width="12%"></th>
          </tr>
        </thead>

        <tbody>
        @foreach($data as $row)
          <tr>
            <td><span class="badge badge-dark">{{ $row->id }}</span></td>
            <td><strong>{{ $row->email }}</strong>

                @if($row->company)
                    <br />
                    {{ $row->company->name }} - {{ $row->company->phone }}
                    @if($row->company->is_approved == 1 && $row->company->is_completed == 1 )
                    <span class="badge badge-success">Approved</span>
                    @endif

                    @if($row->company->is_rejected == 1  && $row->company->is_completed == 0 )
                    <span class="badge badge-danger">Rejected</span>
                    @endif

                    @if($row->company->is_rejected == 1  && $row->company->is_completed == 1 )
                    <span class="badge badge-warning">Resubmission</span>
                    @endif

                    @if($row->company->is_rejected == 0 && $row->company->is_approved == 0 )
                      <span class="badge badge-info">Pending</span>
                    @endif
                @endif
                <br /><small> registered on  {{ $row->created_at }} around {{ $row->created_at->diffForHumans()  }}</small></td>
                <td class="text-center">
                    @php $comments = 0 @endphp
                    @if($row->company)
                        @if($row->company->comments)
                            @php $comments = count($row->company->comments)  @endphp
                        @endif
                    @endif
                    {{ $comments }}
                </td>
                <td class="text-center">
                    @if($row->proposals)

                            {{count($row->proposals) }}

                    @endif
                </td>
                <td>
            @if(!empty($row->getRoleNames()))
              @foreach($row->getRoleNames() as $v)
               {{-- @switch($v)
                  @case('super-admin')
                  <span class="badge badge-danger  text-uppercase ">{{ $v }}</span>
                  @break
                  @case('admin')
                  <span class="badge badge-warning  text-uppercase">{{ $v }}</span>
                  @break
                  @case('user')
                  <span class="badge badge-primary  text-uppercase">{{ $v }}</span>
                  @break
                  @case('subscriber')
                  <span class="badge badge-success  text-uppercase">vendor</span>
                  @break
                @endswitch --}}
                <span class="badge badge-dark text-uppercase ">{{ $v }}</span>
              @endforeach 
            @endif
            </td>

            <td class="float-right">
              <form action="{{ route('users.destroy', $row->id)}}" method="post">
                @csrf @method('DELETE')
              <a class="btn btn-primary btn-sm" href="{{ route('users.show', $row->id) }} ">
                  <i class="fas fa-search">
                  </i>
              </a>
              @role('super-admin')
              <a class="btn btn-success btn-sm" href="{{ route('users.edit', $row->id) }}">
                  <i class="fas fa-pencil-alt">
                  </i>

              </a>
              @endrole


                @role('super-admin')
                    @if(!in_array($row->id,[1,2,3,4]))
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                    @else
                    <button disabled class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                    @endif
                @endrole
              </form>
            </td>
          </tr>


        @endforeach
      </tbody>
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
