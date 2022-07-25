<?php

namespace App\Http\Requests\Screening\Scoring;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreScoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [

           'criteria' => ['required','integer','between:1,40'],
           'storyline' => ['required','integer','between:1,10'],
           'creativity' => ['required','integer','between:1,10'],
           'technical' => ['required','integer','between:1,10'],
           'acting' => ['required','integer','between:1,10'],
           'value_added' => ['required','integer','between:1,20'],

           'comment' => ['required','string'],

           'pematuhan' => ['required','boolean'],
           'is_suitable' => ['required','boolean'],
           'is_comply' => ['required','boolean'],
           'need_statement_comply' => ['required','boolean'],
        ];
    }
}
