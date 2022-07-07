<?php

namespace App\Http\Requests\Pitching\Scoring;

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


           //'pengesahan_comply' => ['required','boolean'],
        ];
    }
}
