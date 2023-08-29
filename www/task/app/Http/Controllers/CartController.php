<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
//        $cart = session()->get('cart', []);
//        return view('cart.show', compact('cart'));
    }
    public function addItemToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Get the product details from the database
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Add the product to the cart in the session
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['message' => 'Product added to cart'], 200);
    }

    public function removeItemFromCart(Request $request)
    {
        $product_id = $request->input('product_id');

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return response()->json(['message' => 'Product removed from cart'], 200);
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }

}
