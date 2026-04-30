<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:120',
            'shipping_state' => 'required|string|max:120',
            'shipping_country' => 'required|string|max:120',
            'shipping_zip' => 'required|string|max:30',
            'order_note' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:card,cod',
            'stripe_payment_method_id' => 'nullable|required_if:payment_method,card|string|max:255',
        ];
    }
}
