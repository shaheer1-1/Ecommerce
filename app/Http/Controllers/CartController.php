<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($product->stock < 1) {
            return back()->with('error', 'Product is out of stock');
        } 
        $cart = Cart::where([
            'user_id' => request()->user()->id
        ])->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => request()->user()->id
            ]);
        }
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
        $product->decrement('stock');

        return back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        return DB::transaction(function () use ($request, $item) {
            $cartItem = CartItem::findOrFail($item->id);
            $product = Product::findOrFail($cartItem->product_id);
            $cartQty = $cartItem->quantity;
            $requestQty = $request->quantity;
            $diff = $requestQty - $cartQty;
            if ($diff > 0) {
                if ($product->stock < $diff) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product is out of stock'
                    ]);
                }
                $product->stock -= $diff;
            }
            else if ($diff < 0) {
                $product->stock += abs($diff);
            }
            $cartItem->update([
                'quantity' => $requestQty
            ]);
            $product->save();
            $cart = $request->user()->cart;
            return response()->json([
                'success'   => true,
                'message'   => 'Cart updated successfully',
                'total_qty' => $cart->items()->sum('quantity'),
                'total'     => $cart->subtotal(),
            ]);
        });
    }
    public function remove(CartItem $item)
    {
        $cartItem = CartItem::find($item->id);
        if (! $cartItem) {
            return back()->with('error', 'Item not found');
        }
        $product = Product::findOrFail($cartItem->product_id);
        $product->stock += $cartItem->quantity;
        $product->save();
        $cartItem->delete();
        return back()->with('success', 'Item removed successfully');
    }
}