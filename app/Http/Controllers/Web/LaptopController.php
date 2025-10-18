<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index(Request $req)
    {
        $bucket = $req->query('price');      // under-15 | 15-20 | over-20
        $sort   = $req->query('sort', 'new'); // new | price_asc | price_desc

        $brands = Brand::whereHas('products', fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', 'laptop')))
            ->orderBy('name')->get();

        $query = Product::with(['brand'])
            ->whereHas('category', fn($c) => $c->where('slug', 'laptop'));

        if ($bucket) $query->priceBucket($bucket);

        $query = match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest('id'),
        };

        $products = $query->paginate(24)->withQueryString();

        return view('laptop.index', compact('brands','products','bucket','sort'))
            ->with('currentBrand', null);
    }

    public function brand(Brand $brand, Request $req)
    {
        $bucket = $req->query('price');
        $sort   = $req->query('sort', 'new');

        $brands = Brand::orderBy('name')->get();

        $query = $brand->products()->with('brand')
            ->whereHas('category', fn($c) => $c->where('slug', 'laptop'));

        if ($bucket) $query->priceBucket($bucket);

        $query = match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest('id'),
        };

        $products = $query->paginate(24)->withQueryString();

        return view('laptop.index', [
            'brands'       => $brands,
            'products'     => $products,
            'bucket'       => $bucket,
            'sort'         => $sort,
            'currentBrand' => $brand,
        ]);
    }
}
