<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where([
            'user_id' => request()->user()->id
        ])->first();
        $cart->load('items.product');

        return view('frontend.cart', [
            'cart' => $cart,
            'total' => $cart->subtotal(),
        ]);
    }
    public function add(Product $product)
    {
        $cart = Cart::where([
            'user_id' => request()->user()->id
        ])->first();
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }
    public function update(Request $request, CartItem $item)
    {
        $line = CartItem::find($item->id);

        if (! $line) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $line->update([
            'quantity' => $request->quantity
        ]);

        $cart = Cart::where([
            'user_id' => request()->user()->id
        ])->first();

        return response()->json([
            'success'   => true,
            'message'   => 'Cart updated successfully',
            'total_qty' => $cart->items()->sum('quantity'),
            'total'     => $cart->subtotal(),
        ]);
    }
    public function remove(CartItem $item)
    {
        $cartItem = CartItem::find($item->id);

        if (! $cartItem) {
            return back()->with('error', 'Item not found');
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed successfully');
    }
}