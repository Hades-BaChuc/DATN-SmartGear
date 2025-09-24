<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Book,Category,Author,Publisher};

class BookSeeder extends Seeder {
  public function run(): void {
    $publisherIds = Publisher::pluck('id')->all();
    // tạo 400 sách
    Book::factory()->count(400)->make()->each(function($b) use($publisherIds){
      $b->publisher_id = fake()->randomElement($publisherIds);
      $b->save();
      // gán 1-3 danh mục con
      $catIds = Category::whereNotNull('parent_id')->inRandomOrder()->take(rand(1,3))->pluck('id');
      $b->categories()->sync($catIds);
      // gán 1-2 tác giả
      $authorIds = Author::inRandomOrder()->take(rand(1,2))->pluck('id');
      $b->authors()->sync($authorIds);
    });
  }
}
