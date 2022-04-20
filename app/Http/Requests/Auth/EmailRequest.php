<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Api\FormRequest; // API response trait

class EmailRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required|string|email|exists:users,email'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Your E-Mail is required, please provide a valid one.',
            'email.string' => 'Your E-Mail should be in string format',
            'email.email' => 'Your E-Mail format is wrong',
            'email.exists' => 'Your E-Mail does not exist',
        ];
    }
}