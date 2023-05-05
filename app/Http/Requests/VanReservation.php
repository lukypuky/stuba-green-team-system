<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VanReservation extends FormRequest
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
            'reason' => 'required',
            'reservation_from' => 'required',
            'reservation_to' => 'required|after:reservation_from',
        ];
    }

    public function messages(){
        return [
            'reason.required' => 'Toto pole je povinné.',
            'reservation_from.required' => 'Toto pole je povinné.',
            'reservation_to.required' => 'Toto pole je povinné.',
            'reservation_to.after' => 'Zadaný čas musí byť po začiatočnom čase.',
        ];
    }
}
