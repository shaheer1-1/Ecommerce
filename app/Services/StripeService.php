<?php

namespace App\Services;

use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripeService
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret', ''));
    }

    public function isConfigured()
    {
        return config('services.stripe.secret', '') !== '' && config('services.stripe.key', '') !== '';
    }

    public function createPaymentIntent(int $amountCents, string $currency = 'usd', array $metadata = [])
    {
        return $this->stripe->paymentIntents->create([
            'amount'                  => $amountCents,
            'currency'                => strtolower($currency),
            'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
            'metadata'                => $metadata,
        ]);
    }

    public function confirmPaymentIntent(string $intentId, string $paymentMethodId)
    {
        return $this->stripe->paymentIntents->confirm($intentId, [
            'payment_method' => $paymentMethodId,
        ]);
    }
}
