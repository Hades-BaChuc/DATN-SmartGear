<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function store(Request $request)
    {
        // Fetch the product by its ID
        $product = Product::find($request->id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        // Get the current cart from the session
        $cart = session()->get('cart', []);

        // Add the product to the cart
        $cart[$product->id] = [
            "name" => $product->product_name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->cover_url,
        ];

        // Save the updated cart to the session
        session()->put('cart', $cart);

        // Redirect the user to the cart page
        return redirect()->route('cart.index');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function buyNow(Request $request)
    {
        $product = Product::find($request->id);

        if ($product) {
            // Lưu sản phẩm vào giỏ hàng
            session()->put('cart', [
                $product->id => [
                    "name" => $product->product_name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->cover_url
                ]
            ]);

            // Tiến hành thẳng đến checkout
            return redirect()->route('checkout.index');  // Đảm bảo không quay lại cart nữa
        }

        return back()->with('error', 'Product not found');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        // Check if the product exists in the cart
        if (isset($cart[$id])) {
            // Update the quantity
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

}


