<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart($request);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Ürün sepete eklendi.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = $this->getCart($request);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            if ($request->quantity > 0) {
                $cartItem->update(['quantity' => $request->quantity]);
            } else {
                $cartItem->delete();
            }
        }

        return redirect()->back()->with('success', 'Sepet güncellendi.');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = $this->getCart($request);
        $cart->items()->where('product_id', $product->id)->delete();

        return redirect()->back()->with('success', 'Ürün sepetten kaldırıldı.');
    }

    protected function getCart(Request $request)
    {
        $sessionId = $request->session()->get('cart_session_id');
        
        if (!$sessionId) {
            $sessionId = Str::uuid();
            $request->session()->put('cart_session_id', $sessionId);
        }

        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => auth()->id()]
        );

        return $cart;
    }
}
