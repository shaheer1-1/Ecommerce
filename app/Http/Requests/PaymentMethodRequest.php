<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stripe_payment_method_id' => 'required|string',
            'cardholder_name'          => 'nullable|string',
            'make_primary'             => 'nullable|boolean',
        ];
    }
}
