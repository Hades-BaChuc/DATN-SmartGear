<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
  public function run(): void {
      $items = [
      ['name' => 'Điện thoại', 'slug' => 'dien-thoai'],
      ['name' => 'Laptop',     'slug' => 'laptop'],
      ['name' => 'Bàn phím',   'slug' => 'ban-phim'],
      ['name' => 'Chuột',      'slug' => 'chuot'],
      ];
      foreach ($items as $it) {
          \App\Models\Category::firstOrCreate(['slug'=>$it['slug']], $it);
      }
    }
}