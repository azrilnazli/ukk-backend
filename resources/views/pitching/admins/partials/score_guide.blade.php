
<h5>PANDUAN PEMARKAHAN</h5>
{{-- <table class="table table-bordered col mt-3 mb-3">
    <tr>
        <td class="bg-danger text-center">GAGAL</td>
        <td class="bg-warning text-center">BIASA</td>
        <td style="background-color:yellow" class="text-center">SEDERHANA BAIK</td>
        <td class="bg-success text-center">BAIK</td>
        <td class="bg-success text-center">SANGAT BAIK</td>
    </tr>
    <tr>
        <td class="text-center">0-79</td>
        <td class="text-center">80-85</td>
        <td class="text-center">86-90</td>
        <td class="text-center">91-95</td>
        <td class="text-center">96-100</td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table> --}}
<table class="table table-bordered col mt-3 mb-3">
    <tr>
    @foreach($scores as $index => $value)
        <td  @if($index === 'sederhana_baik')   class="text-center text-uppercase" style="background-color:yellow" @else class="bg-{{ $value['bg'] }} text-center text-uppercase" @endif>{{ str_replace('_',' ',strToUpper($index))}}</td>
    @endforeach
    </tr>
    <tr>
    @foreach($scores as $index => $value)
        <td  class="text-center text-uppercase">
            @if(!empty($value['score']))
            {{ count($value['score']) }}
            @endif
        </td>
    @endforeach
    </tr>
</table>
