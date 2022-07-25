@php
        $fields =   [
                        'A' =>  [
                                    'title' => 'Cerita (Story) Subject Matters / Isu / Skop',
                                    'name' => 'storyline'
                                ],
                        'B' =>  [
                                    'title' => 'Tema dan Mesej',
                                    'name' => 'theme'
                                ],
                        'C' =>  [
                                    'title' => 'Konsep / Format / Genre',
                                    'name' => 'concept'
                                ],
                        'D' =>  [
                                    'title' => 'Nilai (originality)',
                                    'name' => 'originality'
                                ],
                    ]
    @endphp


    @foreach($fields as $key => $value)
        @if($key == 'A') <h2 class="text-uppercase">idea (40%)</h2> @endif
        <div class="d-flex col-6">
        @include(
            'screening.scorings.partials.form_dropdown',
            array(
                    'id' => $key,
                    'title' => $value['title'],
                    'name' => $value['name'],
                    'message' => !empty($message) ? $message : null ,
                    'screeningScoring' => !empty($screeningScoring) ? $screeningScoring : null
                )
        )
        </div>
    @endforeach


