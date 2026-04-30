<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email:dns|max:100',
            'order_amount' => 'required|integer|min:0',
            
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.string'   => 'Customer name must be a valid string.',
            'order_amount.required'  => 'Order amount is required.',
            'order_amount.integer'   => 'Order amount must be a whole number.',
            'customer_email.max'     => 'Customer email must not exceed 100 characters.',
            'customer_email.dns'     => 'Please provide a valid email address.',
        ];
    }
}
