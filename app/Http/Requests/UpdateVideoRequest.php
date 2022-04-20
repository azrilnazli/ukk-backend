<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
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
            'title'    => ['required',  'max:255'], 
            'synopsis' => ['required'],
            'poster-1' => 'max:10000|mimes:jpeg,jpg,png', //a required, max 10000kb, doc or docx file
            'poster-2' => 'max:10000|mimes:jpeg,jpg,png' //a required, max 10000kb, doc or docx file
        ];  
    }
}
