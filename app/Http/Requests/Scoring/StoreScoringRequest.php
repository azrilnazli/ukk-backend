<?php

namespace App\Http\Requests\Scoring;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreScoringRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
           // scorings
           'assessment' => ['required','in:berwibawa,berupaya,baharu'],
           'need_statement_comply' => ['required', 'boolean'],

           'tajuk_status' => ['required', 'boolean'],
           'tajuk_message' => ['required', 'string'],

           'sinopsis_status' => ['required', 'boolean'],
           'sinopsis_message' => ['required', 'string'],

           'idea_dan_subjek_status' => ['required', 'boolean'],
           'idea_dan_subjek_message' => ['required', 'string'],

           'lengkap_status' => ['required', 'boolean'],
           'lengkap_message' => ['required', 'string'],

        //    'menepati_keperluan_asas_status' => ['required', 'boolean'],
        //    'menepati_keperluan_asas_message' => ['required', 'string'],

           'syor_status' => ['required', 'boolean'],
           'syor_message_true'  => [ 'required_if:syor_status,==,1'],
           'syor_message_false' => [ 'required_if:syor_status,==,0'],

           'pengesahan_comply' => ['required','boolean'],
        ];
    }
}
