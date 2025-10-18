<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    // (tuỳ phiên bản Laravel, có thể không cần dòng này)
    // protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        // Ảnh demo lấy link từ FPTShop
        $images = [
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000000_laptop-1.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000001_laptop-2.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000002_laptop-3.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000003_laptop-4.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000004_laptop-5.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000005_laptop-6.jpg',
        ];

        return [
            'name'   => Str::title($name),
            'slug'   => Str::slug($name) . '-' . Str::lower(Str::random(5)),

            // SKU
            'sku'    => strtoupper($this->faker->bothify('SG-########')),

            // Giá “mặc định” (seeder có thể override để chia bucket)
            'price'            => $this->faker->numberBetween(9_900_000, 39_900_000),
            'discount_percent' => $this->faker->numberBetween(0, 30),
            'stock'            => $this->faker->numberBetween(0, 300),

            'model'           => strtoupper($this->faker->bothify('MD-###')),
            'release_year'    => $this->faker->numberBetween(2018, 2025),
            'warranty_months' => $this->faker->randomElement([6, 12, 18, 24]),

            // sẽ gán trong seeder
            'brand_id'    => null,
            'supplier_id' => null,
            'category_id' => null,

            'description' => $this->faker->paragraph(3),

            // dự án bạn đang dùng cột cover_image
            'cover_image' => $this->faker->randomElement($images),

            'status'      => 'active',
        ];
    }
}
