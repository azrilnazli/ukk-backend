<?php

namespace App\Http\Requests\Tender\TenderSubmission;

use App\Rules\MaxWordsRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            // 'theme' => ['required', 'string', 'max:255'],
            // 'genre' => ['required', 'string', 'max:255'],
            // 'concept' => ['required', 'string', new MaxWordsRule(1000)],

            'synopsis' => ['sometimes', 'string', new MaxWordsRule(1000)],
            'published_year' => ['sometimes','integer'],
            'casts' => ['sometimes','string', 'max:255'],
            'languages' => ['sometimes','string', 'max:255'],
            'total_episode' => ['sometimes','string', 'max:255'],
            'duration' => ['sometimes','string', 'max:255'],
            'country' => ['sometimes','string', 'max:255'],
            'price_episode' => ['sometimes','regex:/^[0-9]*(\.[0-9]{0,2})?$/'],
            'price_overall' => ['sometimes','regex:/^[0-9]*(\.[0-9]{0,2})?$/'],
            'rules' => ['sometimes','string', 'max:255'],
            'informations' => ['sometimes','string', 'max:255'],

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
