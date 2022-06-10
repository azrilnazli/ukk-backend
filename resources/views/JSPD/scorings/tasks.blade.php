
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
    <div class="col-5">
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

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-condensed table-striped">
            <thead>

                <th width="5%">@sortablelink('id', 'ID')</th>

                <th width="*">Company</th>

                <th width="*">@sortablelink('tender.tender_category', 'Category')</th>

                <th width="*">@sortablelink('tender.programme_code', 'Programme Code')</th>

                @hasrole('JSPD-PENANDA')
                <th width="*" class="text-center">Status</th>
                @endhasrole

                @hasrole('JSPD-URUSETIA')
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
                    <td> @if(isset($row->user->company))<span class="badge badge-warning">{{ $row->user->company->id }}</span> {{ $row->user->company->name }}@endif</td>
                    <td>{{ $row->tender->type }} - {{ $row->tender->tender_category }}</td>
                    <td>{{ $row->tender->programme_code }}</td>
                    @hasrole('JSPD-PENANDA')
                    <td class="text-center">{!! optional($row->score)->count() ? '<i class="fas fa-check"></i>' : '<i class="fas fa-hourglass"></i>' !!} </td>
                    @endhasrole

                    @hasrole('JSPD-URUSETIA')
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
                        @php $approved = [] @endphp
                        @foreach($row->scorings as $score)

                            @if( count($row->scorings) == 3 )
                                @if($score->syor_status == 1)
                                    @php
                                        $approved[$score->id] = 1;
                                    @endphp
                                @endif
                            @endif

                        @endforeach


                        @if(count($approved ) > 1)
                            <span class="badge badge-success">SYOR</span>
                        @else
                            <span class="badge badge-secondary">TIDAK</span>
                        @endif

                        @php unset($approved) @endphp
                    </td>
                    @endhasrole

                    <td class="text-center">

                      @hasrole('JSPD-PENANDA')
                        @if( optional($row->score)->count() == 0 )
                        <a class="btn btn-success btn-sm" href="{{ route('scorings.show', $row->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="{{ route('scorings.show', $row->id) }}">
                          <i class="fas fa-search"></i>
                        </a>
                        @endif
                      @endhasrole

                      @hasrole('JSPD-URUSETIA')
                      <a class="btn btn-success btn-sm" href="{{ route('scorings.show_verify', $row->id) }}">
                          <i class="fas fa-pencil-alt"></i>
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
