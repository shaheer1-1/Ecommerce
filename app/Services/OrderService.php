<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private StripeService $stripeService) {}
    public function place(array $data)
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('You must be logged in to place an order.');
        }
        $cart = $user->cart?->load('items.product');
        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception('Your cart is empty.');
        }
        foreach ($cart->items as $item) {
            if (! $item->product) {
                throw new \Exception('A product in your cart is no longer available.');
            }
        }
        return DB::transaction(function () use ($user, $cart, $data) {
            $address = $user->addresses()->create(collect($data)->only([
                'shipping_address',
                'shipping_city',
                'shipping_state',
                'shipping_country',
                'shipping_zip',
            ])->toArray());
            $order = Order::create([
                'user_id'     => $user->id,
                'address_id'  => $address->id,
                'name'        => $data['name'],
                'email'       => $data['email'],
                'phone'       => $data['phone'],
                'total_price' => $cart->subtotal(),
                'status'      => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                ]);
            }
            $this->handlePayment($order, $data);
            $cart->items()->delete();
            return $order;
        });
    }

    private function handlePayment(Order $order, array $data)
    {
        $method = $data['payment_method'] ?? 'cod';
        $total  = $order->total_price;
        if ($method === 'cod') {
            $this->storePayment($order, 'cod', 'pending', $total);
            return;
        }
        if (!$this->stripeService->isConfigured()) {
            throw new \Exception('Stripe is not configured.');
        }
        $intent = $this->stripeService->createPaymentIntent(
            round($total * 100),
            'usd',
            ['order_id' => $order->id, 'user_id' => $order->user_id]
        );
        $intent = $this->stripeService->confirmPaymentIntent(
            $intent->id,
            $data['stripe_payment_method_id'] ?? ''
        );
        if ($intent->status !== 'succeeded') {
            $this->storePayment($order, 'stripe', 'failed', $total);
            throw new \Exception('Stripe payment failed.');
        }
        $this->storePayment($order, 'stripe', 'completed', $total);
        $order->update(['status' => 'completed']);
    }
    private function storePayment(Order $order, string $method, string $status, float $amount): void
    {
        DB::table('payments')->insert([
            'order_id'       => $order->id,
            'payment_method' => $method,
            'status'         => $status,
            'amount'         => $amount,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
