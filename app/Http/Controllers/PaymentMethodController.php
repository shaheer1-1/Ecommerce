<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Services\StripeService;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentMethodRequest;
class PaymentMethodController extends Controller
{
    public function store(PaymentMethodRequest $request, StripeService $stripe)
    {
        $data = $request->validated();
        $card = $stripe->saveCard(
            $request->user(),
            $data['stripe_payment_method_id'],
            $data['make_primary'] ?? false,
            $data['cardholder_name'] ?? null, 
        );
        return response()->json($card->all());
    }
    public function makePrimary(Request $request, PaymentMethod $paymentMethod, StripeService $stripe)
    {
        abort_if($paymentMethod->user_id !== $request->user()->id, 403);
        $stripe->saveCard($request->user(), $paymentMethod->stripe_payment_method_id, true);
        return response()->json(['ok' => true]);
    }
}