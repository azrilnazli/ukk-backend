<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Api\FormRequest; // API response trait

class NewPasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    //  'password' => ['required', 'confirmed', RulesPassword::defaults()],
    public function rules()
    {
        return [

            'password' => 'required|string|min:6|confirmed'
            
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
            'password.required' => 'Password is required'
        ];
    }
}