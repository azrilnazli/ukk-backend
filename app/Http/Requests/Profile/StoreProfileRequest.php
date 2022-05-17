<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:500'],
            'phone' => ['sometimes','regex:/^([0-9\s\-\+\(\)]*)$/', 'string', 'max:15'],
            'password' => ['nullable','confirmed','min:8' ],
            'imgupload' => 'nullable|max:10000|mimes:jpeg,jpg,png' 
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
            'name.required' => 'Your name is required',
            'address.required' => 'Your E-Mail is required',
            'imgupload.mimes'  => 'Only image type is allowed ',
        ];
    }
}
