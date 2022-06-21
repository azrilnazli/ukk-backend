<?php

namespace App\Http\Requests\Tender\TenderDetail;

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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes','string'],
            'date_start' => ['sometimes', 'date'],
            'date_end' => ['sometimes', 'date', 'after:date_start'],
        ];
    }
}
