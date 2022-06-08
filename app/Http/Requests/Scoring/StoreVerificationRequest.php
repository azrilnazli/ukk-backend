<?php

namespace App\Http\Requests\Scoring;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreVerificationRequest extends FormRequest
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
