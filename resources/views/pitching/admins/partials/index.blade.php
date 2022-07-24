
<form method="GET"  action="{{ route('pitching-signers.search') }}">
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

                  <th width="*" class="text-center">Assigned By</th>

                  <th width="*">Scoring</th>
                  <th width="*">Score</th>


                  {{-- <th width="*">Added by</th> --}}
                  <th width="12%" class="text-center"><span class="badge badge-dark">Actions</span></th>
              </thead>

              <tbody>
                  @foreach($proposals as $row)
                  <tr>
                      <td><h1 class="badge badge-dark">{{$row->id }}</h1></td>
                      <td><span class="badge badge-dark">{{ $row->company->id }}</span> {{ $row->company->name }}</td>
                      <td>
                          <span class="badge badge-dark">{{ $row->tender->tender_detail->id}}</span>
                          {{ $row->tender->tender_detail->title}}
                          </td>
                      <td>
                          <span class="badge badge-dark">{{ $row->tender->id}}</span>
                          {{ $row->tender->programme_category }} [ {{ $row->tender->programme_code }} ]
                      </td>

                      <td class="text-center">
                        @if($row->pitching_owner)
                            <span class="badge badge-dark"> {{ $row->pitching_owner->id}}</span>
                            {{ $row->pitching_owner->user->name }}
                        @else
                            Not Assigned
                        @endif
                      </td>


                      <td>
                        @if($row->pitching_scorings)
                            {{ $row->pitching_scorings->count() }}
                        @endif
                        /
                        @if($row->pitching_signers)
                        {{ $row->pitching_signers->count() }}
                        @endif
                      </td>

                      <td>
                        @php
                        unset($score);
                        $score = [];
                        foreach($row->pitching_scorings as $scoring){

                                $score[] = $scoring->total_score;

                        }
                        $total = round((array_sum($score)/300)*100);
                        @endphp
                        <style>
                            .bg-yellow {
                                background-color: yellow;
                                }
                        </style>

                        @switch($total)
                            @case( $total > 0 &&  $total <= 79 )
                                <span class="badge bg-danger">{{ $total }}%</span>
                            @break
                            @case( $total > 80 &&  $total <= 85 )
                                <span class="badge bg-warning">{{ $total }}%</span>
                            @break
                            @case( $total > 86 &&  $total <= 90 )
                                <span class="badge bg-yellow">{{ $total }}%</span>
                            @break
                            @case( $total > 91 &&  $total <= 95 )
                                <span class="badge bg-success">{{ $total }}%</span>
                            @break
                            @case( $total > 96 &&  $total <= 100 )
                            <span class="badge bg-success">{{ $total }}%</span>
                            @break
                        @endswitch

                      </td>


                      <td class="text-center">
                        {{-- @if($row->pitching_scorings)
                            @if($row->pitching_scorings->count() == 3)
                                @if($row->pitching_verification)
                                    <a class="btn btn-su btn-sm" href="{{ route('pitching-verifications.show', $row->id) }}"><i class="fas fa-search"></i></a>
                                @else
                                    <a class="btn btn-su btn-sm" href="{{ route('pitching-verifications.show', $row->id) }}"><i class="fas fa-pencil-alt "></i></a>
                                @endif

                                @else
                                <a class="btn btn-su btn-sm" href="{{ route('pitching-verifications.show', $row->id) }}"><i class="fas fa-search"></i></a>
                            @endif
                        @else
                            <a class="btn btn-su btn-sm" href="{{ route('pitching-verifications.show', $row->id) }}"><i class="fas fa-search"></i></a>
                        @endif --}}
                      </td>
                  </tr>
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
