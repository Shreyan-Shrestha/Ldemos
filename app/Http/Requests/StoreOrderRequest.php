<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'order_amount'  => ['required', 'numeric', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.string'   => 'Customer name must be a valid string.',
            'order_amount.required'  => 'Order amount is required.',
            'order_amount.numeric'   => 'Order amount must be a number.',
            'order_amount.integer'   => 'Order amount must be a whole number.',
        ];
    }
}