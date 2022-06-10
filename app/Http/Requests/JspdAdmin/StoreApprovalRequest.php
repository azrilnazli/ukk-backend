<?php

namespace App\Http\Requests\JspdAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreApprovalRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
           'is_approved' => ['required','boolean'],
        ];
    }
}
