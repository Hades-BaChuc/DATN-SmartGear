<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory {
  public function definition(): array {
    $title = fake('vi_VN')->sentence(3);
    $price = fake()->numberBetween(30000, 300000);
    $discount = fake()->randomElement([0,0,5,10,15,20,30]);
    return [
      'title' => $title,
      'slug'  => Str::slug($title.'-'.Str::random(5)),
      'isbn'  => fake()->unique()->isbn13(),
      'price' => $price,
      'discount_percent' => $discount,
      'stock' => fake()->numberBetween(0,200),
      'format' => fake()->randomElement(['Bìa mềm','Bìa cứng']),
      'language' => fake()->randomElement(['vi','en']),
      'pages' => fake()->numberBetween(80,800),
      'weight' => fake()->numberBetween(100,900),
      'size' => '14x20.5cm',
      'publish_year' => fake()->numberBetween(2000,2025),
      'description' => fake('vi_VN')->paragraph(),
      'cover_image' => 'https://placehold.co/300x400?text=Book',
      'status' => 'active',
    ];
  }
}