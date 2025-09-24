<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
  public function run(): void {
    $tree = [
      ['Văn học','van-hoc', [
        'Tiểu thuyết','Truyện ngắn','Light Novel','Manga - Comic'
      ]],
      ['Kinh tế','kinh-te', [
        'Quản trị','Marketing','Tài chính - Đầu tư','Khởi nghiệp'
      ]],
      ['Tâm lý - Kỹ năng sống','tam-ly-ky-nang', [
        'Kỹ năng sống','Tâm lý học','Nuôi dạy con'
      ]],
      ['Thiếu nhi','thieu-nhi', [
        'Truyện tranh thiếu nhi','Kiến thức bách khoa','Tô màu - Dán hình'
      ]],
      ['Ngoại ngữ','ngoai-ngu', [
        'Tiếng Anh','Tiếng Nhật','Tiếng Hàn'
      ]],
      ['Giáo khoa - Tham khảo','giao-khoa', [
        'Cấp 1','Cấp 2','Cấp 3'
      ]],
    ];

    foreach ($tree as [$name,$slug,$children]) {
      $parent = Category::firstOrCreate(['slug'=>$slug], ['name'=>$name]);
      foreach ($children as $child) {
        Category::firstOrCreate(
          ['slug'=>Str::slug($child)],
          ['name'=>$child, 'parent_id'=>$parent->id]
        );
      }
    }
  }
}