<?php

namespace App\Http\Requests\Screening\Verification;

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
           'is_verified' => ['required','boolean'],
        ];
    }
}
