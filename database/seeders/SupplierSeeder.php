<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder {
  public function run(): void {
    $names = [
      'NXB Trẻ','NXB Kim Đồng','Nhã Nam','Alphabooks',
      'First News - Trí Việt','Thái Hà Products','NXB Lao Động',
      'NXB Tổng Hợp','NXB Phụ Nữ','NXB Hội Nhà Văn'
    ];
    foreach ($names as $n) {
      Supplier::firstOrCreate(['slug'=>Str::slug($n)], ['name'=>$n]);
    }
  }
}