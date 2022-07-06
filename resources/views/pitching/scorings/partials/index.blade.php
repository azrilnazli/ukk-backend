
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

                  <th width="*" class="text-center">Owner</th>
                  <th width="*" class="text-center">Penanda</th>
                  <th width="*" class="text-center">Urusetia</th>
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
                        <span class="badge badge-dark"> {{ optional($row->pitching_owner)->id}}</span>
                        {{ optional($row->pitching_owner)->user->name }}
                      </td>
                      <td class="text-center">{{ optional($row->pitching_signers)->count() }}</td>
                      <td class="text-center">{{ optional($row->pitching_urusetias)->count() }}</td>

                      <td class="text-center">

                        <a class="btn btn-info btn-sm" href="{{ route('pitching-scorings.show', $row->id) }}">
                                <i class="fas fa-search"></i>
                        </a>
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
