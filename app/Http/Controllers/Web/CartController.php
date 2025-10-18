<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []); // [id => qty]
        $ids  = array_keys($cart);

        $items = [];
        if ($ids) {
            $products = Product::whereIn('id', $ids)->get()->keyBy('id');
            foreach ($cart as $id => $qty) {
                if (!isset($products[$id])) continue;
                $p = $products[$id];
                $items[] = [
                    'id'    => $p->id,
                    'name'  => $p->name,
                    'img'   => $p->image ?? '/images/placeholder.jpg',
                    'price' => (int) $p->price,
                    'qty'   => (int) $qty,
                    'attrs' => $p->tags ?? '',
                ];
            }
        }

        return view('cart.index', compact('items'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'id'  => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1|max:99',
        ]);
        $qty = $data['qty'] ?? 1;

        $cart = session('cart', []);
        $cart[$data['id']] = ($cart[$data['id']] ?? 0) + $qty;

        session([
            'cart'       => $cart,
            'cart_count' => array_sum($cart), // dùng cho badge ở navbar
        ]);

        return back()->with('success', 'Đã thêm vào giỏ.');
    }

    public function remove(int $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session([
            'cart'       => $cart,
            'cart_count' => array_sum($cart),
        ]);
        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ.');
    }

    public function clear()
    {
        session()->forget(['cart','cart_count']);
        return back()->with('success', 'Đã làm trống giỏ hàng.');
    }
}
