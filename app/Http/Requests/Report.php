<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Report extends FormRequest
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
            'report_title' => 'required'
        ];
    }

    public function messages(){
        return [
            'report_title.required' => 'je to povinne!'
        ];
    }
}
