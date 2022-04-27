<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            // company profile
            'name' => ['sometimes', 'string', 'max:255'],
            'registration_date' => ['sometimes', 'date', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255',  \Illuminate\Validation\Rule::unique('users')->ignore($this->user()->id) ],
            'phone' => ['sometimes','regex:/^([0-9\s\-\+\(\)]*)$/', 'string', 'max:15'],
            'address' => ['sometimes', 'string', 'max:500'],
            'postcode' => ['sometimes', 'integer' ],
            'city' => ['sometimes', 'string', 'max:100'],
            'states' => ['sometimes', 'string', 'max:100'],
            'board_of_directors' => ['sometimes', 'string', 'max:1000'],
            'paid_capital' => ['sometimes', 'integer'],
            'experiences' => ['sometimes', 'string', 'max:1000'],

            // mof
            'mof_registration_number' => ['sometimes', 'string', 'max:100'],
            'mof_registration_date' => ['sometimes', 'date'],
            'is_mof_active' => ['sometimes', 'boolean'],
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
            // 'name.sometimes' => 'Your name is sometimes',
            // 'address.sometimes' => 'Your E-Mail is sometimes',
            // 'imgupload.mimes'  => 'Only image type is allowed ',
        ];
    }
}
