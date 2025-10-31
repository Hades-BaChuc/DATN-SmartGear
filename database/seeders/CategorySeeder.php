<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
    public function run(){
        $cats = [
            ['name'=>'Điện thoại','slug'=>'dien-thoai'],
            ['name'=>'Laptop','slug'=>'laptop'],
            ['name'=>'Phụ kiện','slug'=>'phu-kien'],
            ['name'=>'TV','slug'=>'tv'],
            ['name'=>'Máy tính bảng','slug'=>'may-tinh-bang'],
        ];
        foreach($cats as $c){ \App\Models\Category::firstOrCreate(['slug'=>$c['slug']],$c); }
    }
}
