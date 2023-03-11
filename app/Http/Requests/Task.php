<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Task extends FormRequest
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
            'type_id' => 'required',
            'task_title' => 'required',
            'priority_id' => 'required',
            'division_id' => 'required',
            'area_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'type_id.required' => 'Toto pole je povinné',
            'task_title.required' => 'Toto pole je povinné',
            'priority_id.required' => 'Toto pole je povinné',
            'division_id.required' => 'Toto pole je povinné!',
            'area_id.required' => 'Toto pole je povinné',
        ];
    }
}
