<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brandIds    = Brand::pluck('id');
        $supplierIds = Supplier::pluck('id');
        $categoryIds = Category::pluck('id');

        // tạo 50 sản phẩm và gán FK ngẫu nhiên
        Product::factory()->count(50)->make()->each(function ($p) use ($brandIds, $supplierIds, $categoryIds) {
            if ($brandIds->isNotEmpty())    $p->brand_id    = $brandIds->random();
            if ($supplierIds->isNotEmpty()) $p->supplier_id = $supplierIds->random();
            if ($categoryIds->isNotEmpty()) $p->category_id = $categoryIds->random();
            $p->save();
        });
    }
}
