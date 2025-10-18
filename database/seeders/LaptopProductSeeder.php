<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaptopProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptopCategoryId = DB::table('categories')->where('slug','laptop')->value('id');

        $images = [
            // Link ảnh ví dụ từ FPTShop (bạn có thể thay cho đẹp hơn)
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000000_laptop-1.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000001_laptop-2.jpg',
            'https://fptshop.com.vn/Uploads/Originals/2023/11/1/638344534000000002_laptop-3.jpg',
        ];

        $cpus = ['Intel Core i3','Intel Core i5','Intel Core i7','AMD Ryzen 5','AMD Ryzen 7'];
        $rams = ['8GB','16GB'];
        $ssds = ['256GB','512GB','1TB'];

        foreach (Brand::all() as $brand) {
            // mỗi hãng 20 sp (như yêu cầu)
            for ($i=1; $i<=20; $i++) {
                // chia bucket giá để có đủ 3 nhóm
                $bucket = match (true) {
                    $i <= 7  => 'under-15',
                    $i <= 14 => '15-20',
                    default  => 'over-20',
                };
                $price = match ($bucket) {
                    'under-15' => rand(9900000, 14990000),
                    '15-20'    => rand(15000000, 19990000),
                    'over-20'  => rand(20000000, 39990000),
                };

                $name = "{$brand->name} " . Arr::random(['VivoBook','Aspire','Modern','ThinkBook','Pavilion','Victus','Gram','MacBook'])
                    . ' ' . Arr::random(['14','15','16']) . '" ' . Arr::random($cpus);

                Product::firstOrCreate(
                    ['slug' => Str::slug($brand->slug.' '.$name.' '.$i)],
                    [
                        'name'        => $name,
                        'brand_id'    => $brand->id,
                        'category_id' => $laptopCategoryId,
                        'price'       => $price,
                        'image_url'   => Arr::random($images),
                        'short_specs' => Arr::random($cpus) . ' · ' . Arr::random($rams) . ' · SSD ' . Arr::random($ssds),
                    ]
                );
            }
        }
    }
}
