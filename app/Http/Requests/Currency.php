<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Currency extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'currency_title' => 'required',
            'currency_symbol' => 'required',
            'shortcut' => 'required',
        ];
    }

    public function messages(){
        return [
            'currency_title.required' => 'Toto pole je povinné.',
            'currency_symbol.required' => 'Toto pole je povinné.',
            'shortcut.required' => 'Toto pole je povinné.',
        ];
    }
}
