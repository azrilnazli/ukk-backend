<?php

namespace App\Http\Requests\Signer;

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
           // signers
           'signers' => ['required'],
           'admins' => ['required'],
        ];
    }
}
