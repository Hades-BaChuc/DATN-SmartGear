<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class; // hoặc dùng PHPDoc @extends trong các phiên bản mới

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(),
            'bio'  => $this->faker->paragraph(),
        ];
    }
}
