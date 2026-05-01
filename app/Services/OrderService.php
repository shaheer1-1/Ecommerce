<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private StripeService $stripe) {}

    public function place(array $data): Order
    {
        $user = Auth::user() ?? throw new \Exception('Not logged in.');
        $cart = $user->cart?->load('items.product');

        if (!$cart || $cart->items->isEmpty()) throw new \Exception('Cart is empty.');

        return DB::transaction(function () use ($user, $cart, $data) {
            $order = Order::create([
                'user_id'     => $user->id,
                'address_id'  => $user->addresses()->create(collect($data)->only([
                    'shipping_address', 'shipping_city', 'shipping_state', 'shipping_country', 'shipping_zip',
                ])->toArray())->id,
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

            $this->handlePayment($order, $user, $data);
            $cart->items()->delete();

            return $order;
        });
    }

    private function handlePayment(Order $order, $user, array $data): void
    {
        if (($data['payment_method'] ?? 'cod') === 'cod') {
            Payment::create(['order_id' => $order->id, 'payment_method' => 'cod', 'status' => 'pending', 'amount' => $order->total_price]);
            return;
        }
        $paymentMethodId = $this->resolveCard($user->id, $data);
        $this->stripe->charge($user, round($order->total_price * 100), $paymentMethodId, [
            'order_id' => $order->id,
        ]);
        Payment::create(['order_id' => $order->id, 'payment_method' => 'stripe', 'status' => 'completed', 'amount' => $order->total_price]);
        $order->update(['status' => 'completed']);

        $usedSavedCard = !empty($data['saved_payment_method_id']);
        $wantsSave = filter_var($data['save_card'] ?? false, FILTER_VALIDATE_BOOLEAN);
        if (!$usedSavedCard && $wantsSave) {
            $makePrimary = filter_var($data['make_primary'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $this->stripe->saveCard($user, $paymentMethodId, $makePrimary, $data['name'] ?? null);
        }
    }

    private function resolveCard(int $userId, array $data)
    {
        if (!empty($data['saved_payment_method_id'])) {
            $pm = PaymentMethod::where('id', $data['saved_payment_method_id'])
                ->where('user_id', $userId)
                ->firstOrFail();
            return  $pm->stripe_payment_method_id;
        }
        if (!empty($data['stripe_payment_method_id'])) {
            return $data['stripe_payment_method_id'];
        }
        return PaymentMethod::where('user_id', $userId)
            ->where('is_primary', true)
            ->value('stripe_payment_method_id') ?? throw new \Exception('No primary card found.');
    }
}