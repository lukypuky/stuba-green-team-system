<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'division_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Toto pole je povinné.',
            'email.required' => 'Toto pole je povinné.',
            'email.email' => 'Zlý formát emailovej adresy.',
            'role_id.required' => 'Toto pole je povinné.',
            'division_id.required' => 'Toto pole je povinné.',
        ];
    }
}
