<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $req)
    {
        $q = Product::query();

        if ($search = $req->query('q')) {
            $q->where(function($qq) use ($search){
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('tags', 'like', "%{$search}%")
                   ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        if ($brand = $req->query('brand')) {
            $q->where('brand', $brand);
        }
        // sort: new | price-asc | price-desc
        $sort = $req->query('sort');
        $q->when($sort === 'price-asc', fn($qq) => $qq->orderBy('price'))
          ->when($sort === 'price-desc', fn($qq) => $qq->orderByDesc('price'))
          ->when($sort === 'new' || !$sort, fn($qq) => $qq->latest('id'));

        $per = min((int) $req->query('per_page', 12), 100);
        $products = $q->paginate($per);

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $products->through(function($p){
                    return [
                        'id'        => $p->id,
                        'name'      => $p->name,
                        'price'     => (int) $p->price,
                        'old_price' => (int) ($p->old_price ?? 0),
                        'brand'     => $p->brand,
                        'image'     => $p->image,
                        'slug'      => $p->slug,
                    ];
                }),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                ],
            ],
            'message' => null,
            'errors'  => null,
        ]);
    }

    public function show(int $id)
    {
        $p = Product::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => (int) $p->price,
                'old_price' => (int) ($p->old_price ?? 0),
                'brand'     => $p->brand,
                'image'     => $p->image,
                'tags'      => $p->tags,
                'slug'      => $p->slug,
            ],
            'message' => null,
            'errors'  => null,
        ]);
    }
}
