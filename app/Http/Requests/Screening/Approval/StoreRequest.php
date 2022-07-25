<?php

namespace App\Http\Requests\Screening\Scoring;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [

           'storyline' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'theme' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'concept' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'originality' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'structure' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'storytelling' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'objective' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'props' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'impact' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'value_added' => ['required','in:1,2,3,4,5,6,7,8,9,10'],
           'comment' => ['required','string'],
           'is_comply' => ['required','boolean'],
        ];
    }
}
