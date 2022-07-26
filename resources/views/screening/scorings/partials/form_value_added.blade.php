    @php
        $fields =   [
                        'A' =>  [
                                    'title' => "
                                                1) Populariti / rating IMDb / MPAA <br />
                                                2) Awards / Anugerah <br />
                                                3) Prospek
                                                ",
                                    'name' => 'value_added'
                                ],

                    ]
    @endphp


    @foreach($fields as $key => $value)
        @if($key == 'A') <h5 class="text-uppercase">nilai tambah komersil (20%)</h5> @endif
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
                    'max' => 20
                )
        )
        </div>
    @endforeach


