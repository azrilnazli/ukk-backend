<?php

namespace App\Http\Requests\Company\CompanyApproval;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // 'title' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     //'unique:categories'
            //     Rule::unique('categories')->ignore($this->category)
            // ],
            // 'description' => ['required', 'string', 'max:2000'],

            'is_approved' => ['required', 'boolean'],
            'message' => ['required', 'string', 'max:1000'],

        ];
    }
}
