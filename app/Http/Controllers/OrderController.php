<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use Search;
    public function index(Request $request)
    {
        $query = Order::query();
        $search = $this->applyNameSearch($query, $request);
        $orders = $query->paginate(10)->withQueryString();
        $user = request()->user();
        if ($user->type === 'admin') {
            return view('admin.orders.index', compact('orders', 'search'));
        }
        return view('frontend.orders.index', compact('orders', 'search'));
    }
    public function show(Order $order)
    { 
        $user = request()->user();
        if ($user->type === 'admin') {
            $order->load('items', 'user');
            return view('admin.orders.show', compact('order'));
        } else {
            $order->load('items');
            return view('frontend.orders.show', compact('order'));
        }
    }
    public function checkout()
    {
        $cart = Auth::user()?->cart?->load('items.product');
        if (empty($cart) || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }
        return view('frontend.checkout', [
            'cart' => $cart,
            'total' => $cart->subtotal(),
            'stripePublicKey' => config('services.stripe.key'),
        ]);
    }
    public function placeOrder(OrderRequest $request, OrderService $orderService)
    {
        try {
            $orderService->place($request->validated());
            return redirect()->route('home')->with('success', 'Your order placed successfully.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage() ?: 'Could not place your order.');
        }
    }
   
}
