<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'card_source' => 'nullable|in:saved,new',
            'saved_payment_method_id' => ['nullable','integer','exists:payment_methods,id',
                Rule::requiredIf(fn () => $this->input('payment_method') === 'card' && $this->input('card_source', 'new') === 'saved'),
             ],
            'stripe_payment_method_id' => ['nullable','string','max:255',
                Rule::requiredIf(fn () =>
                    $this->input('payment_method') === 'card'
                    && $this->input('card_source', 'new') !== 'saved'
                    && empty($this->input('saved_payment_method_id'))
                ),
            ],
            'save_card' => 'nullable|boolean',
            'make_primary' => 'nullable|boolean',
        ];
    }
}
