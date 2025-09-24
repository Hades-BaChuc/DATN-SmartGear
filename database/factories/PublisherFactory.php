<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublisherFactory extends Factory {
  public function definition(): array {
    $name = fake('vi_VN')->company();
    return ['name'=>$name, 'slug'=>Str::slug($name)];
  }
}