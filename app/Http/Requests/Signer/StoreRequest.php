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
           'signers' => ['required_without_all','array','max:3','min:3'],
           'admins' => ['required_without_all','array','max:2','min:1'],
        ];
    }
}
