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
            'task_id' => 'required',
            'report_title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ];
    }

    public function messages(){
        return [
            'task_id.required' => 'Toto pole je povinné',
            'report_title.required' => 'Toto pole je povinné',
            'start_time.required' => 'Toto pole je povinné',
            'end_time.required' => 'Toto pole je povinné!',
            'end_time.after' => 'Zadaný čas musí byť po začiatočnom čase',
        ];
    }
}
