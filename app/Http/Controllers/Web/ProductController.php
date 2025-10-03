<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // GET /products
    public function index()
    {
        $query = Product::with(['brand', 'category'])->latest('id');

        if ($cid = request('category')) {
            $query->where('category_id', $cid);
        }

        $products = $query->paginate(12);

        return view('products.index', [
            'products' => $products,
            'total'    => $products->total(),
        ]);
    }

    // GET /products/{id}
    public function show(int $id)
    {
        $product = Product::with(['brand', 'supplier', 'category'])->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
