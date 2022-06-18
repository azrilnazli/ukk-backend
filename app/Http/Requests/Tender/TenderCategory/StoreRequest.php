<?php

namespace App\Http\Requests\Tender\TenderCategory;

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
            'tender_detail_id' => ['required','not_in:0'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ];
    }
}
