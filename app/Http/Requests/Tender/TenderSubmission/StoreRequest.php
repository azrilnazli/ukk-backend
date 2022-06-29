<?php

namespace App\Http\Requests\Tender\TenderSubmission;

use App\Rules\MaxWordsRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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

            'synopsis' => ['required', 'string', new MaxWordsRule(1000)],
            'published_year' => ['required','integer'],
            'casts' => ['required','string', 'max:255'],
            'languages' => ['required','string', 'max:255'],
            'total_episode' => ['required','string', 'max:255'],
            'duration' => ['required','string', 'max:255'],
            'country' => ['required','string', 'max:255'],
            'price_episode' => ['required','integer'],
            'price_overall' => ['required','integer'],
            'rules' => ['required','string', 'max:255'],
            'informations' => ['required','string', 'max:255'],

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
