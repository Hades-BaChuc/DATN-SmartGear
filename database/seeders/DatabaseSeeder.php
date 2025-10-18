<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run(): void {
    $this->call([
      CategorySeeder::class,
      SupplierSeeder::class,
      BrandSeeder::class,
      ProductSeeder::class,
      DemoDataSeeder::class,
    ]);

    $this->call([
      BrandSeeder::class,
      LaptopProductSeeder::class,
    ]);
  }
}
