
@extends('layouts.master')

@section('title', 'Tender List')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('scorings.tasks')}}">{{ __('Scoring Index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Proposal List</li>
    </ol>
</nav>
@stop

@section('content')

<form method="GET"  action="{{ route('scorings.search') }}">
  @csrf
  <div class="row mt-5">
    <div class="col-6">
      <input required type="text" name="query" value="{{ old('query', !empty($_GET['query']) ? $_GET['query'] : null ) }}"  class="form-control" placeholder="Search">
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

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">@sortablelink('id', 'ID')</th>

                <th width="*">Company</th>

                <th width="*">Type</th>

                <th width="*">Tender</th>

                @hasrole('jspd-penanda')
                    <th width="*" class="text-center">Status</th>
                @endhasrole

                @hasrole('jspd-urusetia')
                    <th width="*" class="text-center">Owner</th>

                    <th width="*" class="text-center">Signed</th>
                    <th width="*" class="text-center">Verified</th>
                    <th width="*" class="text-center">Pengesyoran</th>
                @endhasrole
                <th width="12%" class="text-center"><span class="badge badge-dark">Actions</span></th>
            </thead>

            <tbody>
                @foreach($proposals as $row)
                @if(isset($row->user->company))
                <tr>
                    <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                    <td><span class="badge badge-dark">{{ $row->company->id }}</span> {{ $row->company->name }}</td>
                    <td>
                        <span class="badge badge-dark">{{ $row->tender->tender_detail->id }}</span>
                        {{ $row->tender->tender_detail->title }}
                    </td>
                    <td>
                        <span class="badge badge-dark">{{ $row->tender->id }}</span>
                        {{ $row->tender->programme_category }} [ {{ $row->tender->programme_code }} ]
                    </td>
                    @hasrole('jspd-penanda')
                        <td class="text-center">{!! optional($row->my_score)->count() ? '<i class="fas fa-check"></i>' : '<i class="fas fa-hourglass"></i>' !!} </td>
                    @endhasrole

                    @hasrole('jspd-urusetia')
                        <td class="text-center">
                            <span class="badge badge-dark"> {{ optional($row->owner)->id}}</span>
                            {{ optional($row->owner)->name}}
                        </td>

                        <td class="text-center">
                        {{ optional($row->scorings)->count() }}/{{ optional($row->signers)->count() }}
                        </td>

                        <td class="text-center">
                        {{ optional($row->verifications)->count() }}/{{ optional($row->urusetias)->count() }}
                        </td>

                        <td class="text-center">
                            @if(count( $row->approved ) > 1)
                                <span class="badge badge-success">SYOR</span>
                            @else
                                <span class="badge badge-secondary">TIDAK</span>
                            @endif

                        </td>
                    @endhasrole

                    <td class="text-center">

                      @hasrole('jspd-penanda')
                        @if( optional($row->my_score)->count() == 0 )
                        <a class="btn btn-success btn-sm" href="{{ route('scorings.show', $row->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="{{ route('scorings.show', $row->id) }}">
                          <i class="fas fa-search"></i>
                        </a>
                        @endif
                      @endhasrole

                      @hasrole('jspd-urusetia')
                        <a class="btn btn-success btn-sm" href="{{ route('scorings.show_verify', $row->id) }}">
                            <i class="fas fa-search"></i>
                        </a>
                      @endhasrole


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
