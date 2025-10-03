<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // 4 danh mục chính theo slug (hoặc fallback bằng tên)
        $slugs = [
            'dien-thoai' => 'Điện thoại',
            'laptop'     => 'Laptop',
            'ban-phim'   => 'Bàn phím',
            'chuot'      => 'Chuột',
        ];

        $categories = collect();
        foreach ($slugs as $slug => $fallbackName) {
            $cat = Category::where('slug', $slug)->first()
                ?? Category::where('name', 'like', $fallbackName.'%')->first();
            if ($cat) $categories->push($cat);
        }

        // sản phẩm nổi bật (random/hoặc latest)
        $featured = Product::with('brand')->latest('id')->take(8)->get();

        // gợi ý theo từng danh mục, nếu có
        $byCategory = [];
        foreach ($categories as $cat) {
            $byCategory[$cat->slug] = Product::with('brand')
                ->where('category_id', $cat->id)
                ->latest('id')->take(8)->get();
        }

        return view('home', compact('categories', 'featured', 'byCategory'));
    }
}
