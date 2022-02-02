<?php

namespace Asadbek\Eimzo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EriRequest extends FormRequest
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
            'eri_fullname' => 'required|string',
            // 'eri_inn' => 'required|numeric|digits:9',
            'eri_pinfl' => 'required|numeric|digits:14',
            'eri_data' => 'required',
            'eri_hash' => 'required',
            'eri_sn' => 'required',
        ];
    }
}
