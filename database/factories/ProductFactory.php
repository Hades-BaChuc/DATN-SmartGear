<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name'   => $name,
            'slug'   => Str::slug($name) . '-' . Str::lower(Str::random(5)),
            // SKU hợp lệ (chọn 1 trong 2 dòng dưới – đang dùng bothify)
            'sku'    => strtoupper($this->faker->bothify('SG-########')), // ví dụ: SG-12345678
            // 'sku' => strtoupper($this->faker->regexify('[A-Z0-9]{8}')), // ví dụ: 8 ký tự A-Z0-9

            'price'  => $this->faker->numberBetween(200000, 5000000),
            'discount_percent' => $this->faker->numberBetween(0, 30),
            'stock'  => $this->faker->numberBetween(0, 300),

            'model'         => strtoupper($this->faker->bothify('MD-###')),
            'release_year'  => $this->faker->numberBetween(2018, 2025),
            'warranty_months' => $this->faker->randomElement([6, 12, 18, 24]),

            'brand_id'    => null,  // sẽ gán trong seeder
            'supplier_id' => null,  // sẽ gán trong seeder
            'category_id' => null,  // sẽ gán trong seeder

            'description' => $this->faker->paragraph(3),
            'cover_image' => null,
            'status'      => 'active',
        ];
    }
}
