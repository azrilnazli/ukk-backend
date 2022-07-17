@php
        $fields =   [
                        'A' =>  [
                                    'title' => 'Premis dan Struktur',
                                    'name' => 'structure'
                                ],
                        'B' =>  [
                                    'title' => 'Penceritaan (Storytelling), Treatment/Style/Approach',
                                    'name' => 'storytelling'
                                ],
                        'C' =>  [
                                    'title' => 'Objektif',
                                    'name' => 'objective'
                                ],
                        'D' =>  [
                                    'title' => 'Artis/Set/Lokasi/FX',
                                    'name' => 'props'
                                ],
                        'E' =>  [
                                    'title' => 'Impak (Penonton Sasar)',
                                    'name' => 'impact'
                                ],
                        'F' =>  [
                                    'title' => 'Nilai Tambah',
                                    'name' => 'value_added'
                                ],
                    ]
    @endphp


    @foreach($fields as $key => $value)
        @if($key == 'A') <h2 class="text-uppercase">kandungan (60%)</h2> @endif
        <div class="d-flex col-8">

        @include(
            'pitching.scorings.partials.form_dropdown',
            array(
                    'id' => $key,
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'message' => !empty($message) ? $message : null ,
                    'pitchingScoring' => !empty($pitchingScoring) ? $pitchingScoring : null
                )
        )
        </div>
    @endforeach


