<?php

namespace App\Services;

use App\Models\User;
use App\Models\PaymentMethod;
use Stripe\StripeClient;
use Illuminate\Support\Facades\DB;

class StripeService
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(setting('stripe_secret_key', null));
    }

    public function isConfigured(): bool
    {
        return !empty(setting('stripe_secret_key', '')) && !empty(setting('stripe_public_key', ''));
    }
    public function customer(User $user)
    {
        if ($user->stripe_customer_id){
            return $user->stripe_customer_id;
        }
        $customer = $this->stripe->customers->create([
            'email' => $user->email,
            'name'  => $user->name,
        ]);
        $user->forceFill(['stripe_customer_id' => $customer->id])->save();
        return $customer->id;
    }
    public function saveCard(User $user, string $paymentMethodId, bool $makePrimary = false, ?string $cardholderName = null)
    {
        $customerId = $this->customer($user);
        $paymentMethod = $this->stripe->paymentMethods->retrieve($paymentMethodId);
        if (empty($paymentMethod->customer)) {
            $this->stripe->paymentMethods->attach($paymentMethodId, ['customer' => $customerId]);
            $paymentMethod = $this->stripe->paymentMethods->retrieve($paymentMethodId);
        }
        return DB::transaction(function () use ($user, $paymentMethod, $paymentMethodId, $customerId, $makePrimary, $cardholderName) {
            $card = PaymentMethod::updateOrCreate(
                ['stripe_payment_method_id' => $paymentMethodId],
                [
                    'user_id'         => $user->id,
                    'brand'           => $paymentMethod->card->brand,
                    'last4'           => $paymentMethod->card->last4,
                    'exp_month'       => $paymentMethod->card->exp_month,
                    'exp_year'        => $paymentMethod->card->exp_year,
                    'cardholder_name' => $cardholderName,
                ]
            );
            if ($makePrimary || !$user->paymentMethods()->where('id', '!=', $card->id)->exists()){
                $user->paymentMethods()->update(['is_primary' => false]);
                $card->update(['is_primary' => true]);
                $this->stripe->customers->update($customerId, [
                    'invoice_settings' => ['default_payment_method' => $paymentMethodId],
                ]);
            }
            return $card->fresh();
        });
    }

    public function charge(User $user, int $amountCents, string $paymentMethodId, array $metadata = [])
    {
        $customerId = $this->customer($user);

        $intent = $this->stripe->paymentIntents->create([
            'amount'               => $amountCents,
            'currency'             => 'usd',
            'customer'             => $customerId,
            'payment_method'       => $paymentMethodId,
            'confirm'              => true,
            'off_session'          => true,
            'metadata'             => $metadata,
            'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
        ]);

        if ($intent->status !== 'succeeded') {
            throw new \Exception('Payment failed: ' . $intent->status);
        }

        return $intent;
    }
   
}