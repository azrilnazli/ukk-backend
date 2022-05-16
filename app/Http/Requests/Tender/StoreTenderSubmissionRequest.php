<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenderSubmissionRequest extends FormRequest
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
            'theme' => ['sometimes', 'string', 'max:255'],
            'genre' => ['sometimes', 'string', 'max:255'],
            'concept' => ['sometimes', 'string', 'max:255'],
            'synopsis' => ['sometimes', 'string', 'max:255'],
          
            "selectedFile" => "sometimes|mimes:pdf|max:1000000",
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
