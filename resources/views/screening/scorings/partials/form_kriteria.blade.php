    @php
        $fields =   [
                        'A' =>  [
                                    'title' => "
                                                1) Konsep / Keperluan Saluran <br />
                                                2) Nilai Kandungan
                                                ",
                                    'name' => 'criteria'
                                ],

                    ]
    @endphp


    @foreach($fields as $key => $value)
        @if($key == 'A') <h5 class="text-uppercase">kriteria (40%)</h5> @endif
        <div class="d-flex col-8">
        @include(
            'screening.scorings.partials.form_dropdown',
            array(
                    'id' => $key,
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'message' => !empty($message) ? $message : null ,
                    'screeningScoring' => !empty($screeningScoring) ? $screeningScoring : null,
                    'min' => 0,
                    'max' => 40
                )
        )
        </div>
    @endforeach


