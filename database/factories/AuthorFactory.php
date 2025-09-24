<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AuthorFactory extends Factory {
  public function definition(): array {
    $name = fake('vi_VN')->name();
    return ['name'=>$name, 'slug'=>Str::slug($name)];
  }
}