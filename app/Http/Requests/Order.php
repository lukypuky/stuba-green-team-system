<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Order extends FormRequest
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
            'order_number' => 'required',
            'order_title' => 'required',
            'formula_part_specify_id' => 'required',
            'quantity' => 'required|numeric|min:0',
            'price_per_piece' => 'required|numeric|min:0',
            'price_total' => 'required|numeric|min:0',
            'currency_id' => 'required',
            'shop' => 'required',
            'link' => 'required',
            'order_priority_id' => 'required',
            'order_status_id' => 'required',
        ];
    }

        public function messages(){
        return [
            'order_number.required' => 'Toto pole je povinné.',
            'order_title.required' => 'Toto pole je povinné.',
            'formula_part_specify_id.required' => 'Toto pole je povinné.',
            'quantity.required' => 'Toto pole je povinné.',
            'quantity.numeric' => 'Chybne zadané množstvo.',
            'quantity.min' => 'Chybne zadané množstvo.',
            'price_per_piece.required' => 'Toto pole je povinné.',
            'price_per_piece.numeric' => 'Chybne zadaná cena.',
            'price_per_piece.min' => 'Chybne zadaná cena.',
            'price_total.required' => 'Toto pole je povinné.',
            'price_total.numeric' => 'Chybne zadaná cena.',
            'price_total.min' => 'Chybne zadaná cena.',
            'currency_id.required' => 'Toto pole je povinné.',
            'shop.required' => 'Toto pole je povinné.',
            'link.required' => 'Toto pole je povinné.',
            'order_priority_id.required' => 'Toto pole je povinné.',
            'order_status_id.required' => 'Toto pole je povinné.',
        ];
    }
}
