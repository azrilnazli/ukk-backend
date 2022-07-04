

@foreach($company->user->videos as $row)
<div class="card-body p-2 mt-2" >
    <div class="alert   rounded">
      <table class="table">
        <thead>
          <tr class="bg-secondary">
            <th width="2%">ID</th>
            <th width="5%">Filename</th>
            <th width="15%">Format</th>
            <th width="15%">Size</th>
            <th width="15%">Length</th>

            <th width="*">Date</th>

            <th width="20%" class="text-center">Actions</th>
          </tr>
        </thead>

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
          <span>  {{ $row->uploaded_size}}</span>
        </td>
        <td>
          <span>  {{ $row->length}}</span>
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


      <tr>
          <td colspan="8">

          <div class="form-group">

                <div class="form-group">
                    <label>Original Video : </label>
                    <a class="text-dark" href="https://admin-ukk.rtm.gov.my:8080/{{ $row->id }}/original.mp4" target="_blank">{{$row->original_filename}}</a>
                </div>

              <label>Encoding Progress : </label>
              {{ $row->encoding_progress }} %
              </div>

              @if($row->exception)
              <div class="form-group">
              <label>Error</label>
              <textarea class="form-control bg-light" id="exampleFormControlTextarea1" rows="5">{{ $row->exception }}</textarea>
              </div>
              @endif
          </td>
      </tr>

    </tbody>
  </table>
</div>
</div>
<!-- /.card-body -->
@endforeach
