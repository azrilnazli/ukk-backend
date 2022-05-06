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
            'registration_date' => ['sometimes', 'date', 'before:today'],
            'email' => ['sometimes', 'string', 'email', 'max:255',  \Illuminate\Validation\Rule::unique('companies')->ignore($this->user()->id) ],
            'phone' => ['sometimes','regex:/^([0-9\s\-\+\(\)]*)$/', 'string', 'max:15'],
            'address' => ['sometimes', 'string', 'max:500'],
            'postcode' => ['sometimes', 'integer' ],
            'city' => ['sometimes', 'string', 'max:100'],
            'states' => ['sometimes', 'string', 'max:100'],
            'board_of_directors' => ['sometimes', 'string', 'max:1000'],
            'experiences' => ['sometimes', 'string', 'max:1000'],

            // mof
            'mof_registration_number' => ['sometimes', 'string', 'max:100'],
            'mof_expiry_date' => ['sometimes', 'date', 'after:today'],
            'is_mof_active' => ['sometimes', 'boolean'],

            // ssm
            'ssm_registration_number' => ['sometimes', 'string', 'max:100'],
            'ssm_expiry_date' => ['sometimes', 'date',  'after:today'],

            // finas_fp
            'finas_fp_registration_number' => ['sometimes', 'string', 'max:100'],
            'finas_fp_expiry_date' => ['sometimes', 'date',  'after:today'],

            // finas_fd
            'finas_fd_registration_number' => ['sometimes', 'string', 'max:100'],
            'finas_fd_expiry_date' => ['sometimes', 'date',  'after:today'],            

            // KKMM Syndicated
            'kkmm_syndicated_registration_number' => ['sometimes', 'string', 'max:100'],
            'kkmm_syndicated_expiry_date' => ['sometimes', 'date',  'after:today'],   
            
            // KKMM Swasta
            'kkmm_swasta_registration_number' => ['sometimes', 'string', 'max:100'],
            'kkmm_swasta_expiry_date' => ['sometimes', 'date',  'after:today'],  

            // audit data
            'current_audit_year' => ['sometimes', 'date'],
            'paid_capital' => ['sometimes', 'integer'],

            // status bumiputera
            'bumiputera_registration_number' => ['sometimes', 'string', 'max:100'],
            'bumiputera_registration_date' => ['sometimes', 'date'],
            'is_bumiputera' => ['sometimes', 'boolean'],
            'bumiputera_expiry_date' => ['sometimes', 'date',  'after:today'],


            // banking data
            'bank_name' => ['sometimes', 'string', 'max:100'],
            'bank_branch' => ['sometimes', 'string', 'max:100'],
            'bank_account_number' => ['sometimes', 'string', 'max:100'],
            'bank_statement_date_start' => ['sometimes', 'date'],
            'bank_statement_date_end' => ['sometimes', 'date', 'after:bank_statement_date_start'],
            

            // file upload
            "selectedFile" => "sometimes|mimes:pdf|max:10000",

            // Administration
            'is_approved' => ['sometimes', 'boolean'],
            'is_uploaded' => ['sometimes', 'boolean'],
            
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
