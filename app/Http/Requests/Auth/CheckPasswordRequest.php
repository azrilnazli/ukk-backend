<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Api\FormRequest; // API response trait

class CheckPasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    //  'password' => ['required', 'confirmed', RulesPassword::defaults()],
    public function rules()
    {
        return [

            'current_password' => 'required'
            
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
            'current_password.required' => 'Password is required'
        ];
    }
}