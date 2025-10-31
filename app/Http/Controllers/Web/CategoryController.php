<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\{Product,Category};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller {
    public function show(Request $r, string $slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();

        // Tạo query để lấy sản phẩm theo category
        $q = Product::query()->whereHas('categories', function (Builder $b) use ($category) {
            $b->where('categories.id', $category->id);
        });

        if ($s = $r->query('q')) {
            $q->where('name','like',"%$s%");
        }

        // Lấy sản phẩm với danh mục
        $products = $q->with('categories')->orderByDesc('id')->paginate(24)->withQueryString();

        return view('category', compact('category', 'products'));
    }

}
