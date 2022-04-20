<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Api\FormRequest; // API response trait

class ResetRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    //  'password' => ['required', 'confirmed', RulesPassword::defaults()],
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|min:8|confirmed'
            
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
            'token.required' => 'Missing token',

            'email.required' => 'Your E-Mail is required',
            'email.string' => 'Your E-Mail should be in string format',
            'email.email' => 'Your E-Mail format is wrong',
            'email.exists' => 'Your E-Mail is not exist',
        ];
    }
}