<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q     = $request->string('q');
        $brand = $request->string('brand');
        $sort  = $request->string('sort');

        $query = Product::query();

        if ($q->isNotEmpty()) {
            $query->where('name', 'like', '%'.$q.'%');
        }
        if ($brand->isNotEmpty()) {
            $query->where('brand', $brand);
        }

        // sort: popular | price-asc | price-desc | new
        $query->when($sort === 'price-asc', fn($q) => $q->orderBy('price'))
              ->when($sort === 'price-desc', fn($q) => $q->orderByDesc('price'))
              ->when($sort === 'new', fn($q) => $q->latest('id'));

        $products = $query->paginate(12)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(int $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
}
