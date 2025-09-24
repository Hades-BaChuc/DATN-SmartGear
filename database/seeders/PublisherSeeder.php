<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Publisher;
use Illuminate\Support\Str;

class PublisherSeeder extends Seeder {
  public function run(): void {
    $names = [
      'NXB Trẻ','NXB Kim Đồng','Nhã Nam','Alphabooks',
      'First News - Trí Việt','Thái Hà Books','NXB Lao Động',
      'NXB Tổng Hợp','NXB Phụ Nữ','NXB Hội Nhà Văn'
    ];
    foreach ($names as $n) {
      Publisher::firstOrCreate(['slug'=>Str::slug($n)], ['name'=>$n]);
    }
  }
}