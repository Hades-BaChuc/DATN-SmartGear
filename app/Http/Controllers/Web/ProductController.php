<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;   // <-- thêm dòng này

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q        = $request->string('q')->toString();
        $brand    = $request->string('brand')->toString();
        $category = $request->string('category')->toString();
        $sort     = $request->string('sort')->toString();
        $min      = $request->query('min');
        $max      = $request->query('max');

        $query = Product::query()->with(['brand:id,name,slug', 'categories:id,name,slug']);

        // Ẩn sản phẩm nếu có cột is_hidden
        if (Schema::hasColumn('products', 'is_hidden')) {
            $query->where('is_hidden', 0);
        }

        // Tìm kiếm theo tên sản phẩm
        if ($q !== '') {
            $query->where(function($qq) use ($q) {
                if (Schema::hasColumn('products', 'product_name')) {
                    $qq->orWhere('product_name', 'like', "%{$q}%");
                }
                if (Schema::hasColumn('products', 'name')) {
                    $qq->orWhere('name', 'like', "%{$q}%");
                }
                $qq->orWhere('slug', 'like', "%{$q}%");
            });
        }

        // Lọc theo thương hiệu (brand)
        if ($brand !== '') {
            $query->whereHas('brand', fn($b) => $b->where('slug', $brand)->orWhere('name', $brand));
        }

        // Lọc theo danh mục (category)
        if ($category !== '') {
            $query->whereHas('categories', fn($c) => $c->where('slug', $category)->orWhere('name', $category));
        }

        // Kiểm tra bảng 'product_details' nếu có, để lọc theo giá
        $hasDetails = Schema::hasTable('product_details') || Schema::hasTable('product_detail');

        if ($hasDetails) {
            $query->withMin('details', 'price');
            if (is_numeric($min) || is_numeric($max)) {
                $query->whereHas('details', function($qd) use($min, $max) {
                    if (is_numeric($min)) $qd->where('price', '>=', $min);
                    if (is_numeric($max)) $qd->where('price', '<=', $max);
                });
            }
            switch ($sort) {
                case 'price-asc'  : $query->orderBy('details_min_price'); break;
                case 'price-desc' : $query->orderByDesc('details_min_price'); break;
                case 'popular'    : $query->orderByDesc('view'); break;
                default           : $query->latest('id'); // new
            }
        } else {
            if (is_numeric($min)) $query->where('price', '>=', $min);
            if (is_numeric($max)) $query->where('price', '<=', $max);
            switch ($sort) {
                case 'price-asc'  : $query->orderBy('price'); break;
                case 'price-desc' : $query->orderByDesc('price'); break;
                case 'popular'    : $query->orderByDesc('view'); break;
                default           : $query->latest('id');
            }
        }

        // Phân trang thay vì get()
        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = \App\Models\Product::with([
            'images' => fn($q) => $q->orderBy('position'),
            'brand',
            'categories'  // Sửa ở đây từ 'category' thành 'categories'
        ])->where('slug', $slug)
            ->firstOrFail();

        $related = \App\Models\Product::where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->take(8)
            ->get();

        $reviews = \App\Models\Review::where('product_id', $product->id)
            ->latest()
            ->take(10)
            ->get();

        return view('products.show', compact('product', 'related', 'reviews'));
    }


}
