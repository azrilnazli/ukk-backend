<?php

namespace App\Http\Requests\Tender\TenderDetail;

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
            'title' => ['required', 'string', 'max:255'],
            'login_text' => ['required'],
            'dashboard_text' => ['required'],
            'proposal_text' => ['required'],
            'date_start' => ['sometimes', 'date'],
            'date_end' => ['sometimes', 'date', 'after:date_start'],
        ];
    }
}
