<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()->with(['brand','supplier','category']);

        if ($request->filled('category')) $q->where('category_id', $request->integer('category'));
        if ($request->filled('brand'))    $q->where('brand_id', $request->integer('brand'));
        if ($request->filled('q'))        $q->where('name', 'like', '%'.$request->q.'%');

        $products = $q->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
