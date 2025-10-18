<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptopCategoryId = \DB::table('categories')->where('slug','laptop')->value('id');

        foreach (Brand::all() as $brand) {
            Product::factory()
                ->count(20)
                ->create([
                    'brand_id'    => $brand->id,
                    'category_id' => $laptopCategoryId,
                ]);
        }
    }
}
