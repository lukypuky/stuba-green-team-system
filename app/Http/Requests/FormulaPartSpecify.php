<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormulaPartSpecify extends FormRequest
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
            'formula_part_specify_title' => 'required',
        ];
    }

    public function messages(){
        return [
            'formula_part_specify_title.required' => 'Toto pole je povinné',
        ];
    }
}
