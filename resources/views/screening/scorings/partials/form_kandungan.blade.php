@php
        $fields =   [
                        'A' =>  [
                                    'title' => "
                                                Cerita <br />
                                                1) Premise/Storyline dan Struktur <br />
                                                2) Jalinan Cerita ( Plot/ Pacing ) <br />
                                                3) Tema / Mesej / Genre <br />
                                                4) Objektif / Impak <br />


                                                ",
                                    'name' => 'storyline'
                                ],
                        'B' =>  [
                                    'title' => "
                                                Pengarahan <br />
                                                1) Idea/style/approach/visi <br />
                                                2) Kreativiti / Mise en Scene <br />
                                                3) Production / Art Design <br />
                                                "
                                                ,

                                     'name' => 'creativity'
                                ],
                        'C' =>  [
                                    'title' => "
                                                Technical <br />
                                                1) Sinematografi / Camera works <br />
                                                2) Pencahayaan <br />
                                                3) Penataan Bunyi / Skor Muzik, Suntingan, Teknik & FX <br />
                                                ",
                                    'name' => 'technical'
                                ],
                        'D' =>  [
                                    'title' => "
                                                Lakonan / Persembahan <br />
                                                1) Artis / Personaliti / Karektor / Interprestasi / Improvisasi / Style / Tone <br />
                                                ",
                                    'name' => 'acting'
                                ],


                    ]
    @endphp


    @foreach($fields as $key => $value)
        @if($key == 'A') <h5 class="text-uppercase">kandungan (40%)</h5> @endif
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
                    'max' => 10
                )
        )
        </div>
    @endforeach


