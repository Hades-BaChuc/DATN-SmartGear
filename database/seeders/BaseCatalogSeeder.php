<?php

// database/seeders/BaseCatalogSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class BaseCatalogSeeder extends Seeder {
  public function run(): void {
    $brands = ['ASUS','ACER','MSI','LENOVO','DELL','HP','LG'];
    foreach ($brands as $b) {
      DB::table('brands')->updateOrInsert(
        ['name'=>$b],
        ['slug'=>Str::slug($b), 'is_featured'=>true]
      );
    }

    $cats = [
      ['name'=>'Laptop','children'=>[
        ['name'=>'Laptop ASUS'], ['name'=>'Laptop ACER']
      ]],
      ['name'=>'Màn hình'],
      ['name'=>'Điện thoại'],
      ['name'=>'Chuột + Lót chuột'],
      ['name'=>'Tai nghe'],
    ];
    foreach ($cats as $c) {
      $parentId = DB::table('categories')->updateOrInsert(
        ['name'=>$c['name']],
        ['slug'=>Str::slug($c['name']), 'parent_id'=>null, 'is_active'=>1]
      ) ? DB::table('categories')->where('name',$c['name'])->value('id') : null;

      foreach ($c['children'] ?? [] as $child) {
        DB::table('categories')->updateOrInsert(
          ['name'=>$child['name']],
          ['slug'=>Str::slug($child['name']), 'parent_id'=>$parentId, 'is_active'=>1]
        );
      }
    }
  }
}

