<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskType extends FormRequest
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
            'task_type_title' => 'required',
        ];
    }

    public function messages(){
        return [
            'task_type_title.required' => 'Toto pole je povinné.',
        ];
    }
}
