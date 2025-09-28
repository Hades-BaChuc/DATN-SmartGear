<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder {
  public function run(): void {
    Brand::factory()->count(60)->create();
  }
}