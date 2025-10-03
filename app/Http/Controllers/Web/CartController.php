<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []); // [product_id => ['product' => Product, 'qty' => int, 'price' => int]]
        $total = collect($cart)->sum(fn($row) => $row['qty'] * $row['price']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1',
        ]);
        $qty = max(1, (int) $request->input('qty', 1));

        $product = Product::findOrFail($request->product_id);

        $cart = session('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'product' => $product,
                'qty'     => $qty,
                'price'   => $product->price,
            ];
        }
        session(['cart' => $cart]);

        return back()->with('success', 'Đã thêm vào giỏ.');
    }

    public function remove(int $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Đã xoá khỏi giỏ.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Đã làm trống giỏ hàng.');
    }
}
