<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GearSampleSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 0) Chuẩn brand & category =====
        // Brands bạn đã có 7 cái; đảm bảo tồn tại + lấy id map
        $brandNames = ['ASUS','ACER','MSI','LENOVO','DELL','HP','LG'];
        $brandIds = [];
        foreach ($brandNames as $b) {
            DB::table('brands')->updateOrInsert(
                ['name' => $b],
                ['slug' => Str::slug($b), 'is_featured' => true]
            );
            $brandIds[$b] = (int) DB::table('brands')->where('name',$b)->value('id');
        }

        // Categories mong muốn (nếu chưa có thì tạo)
        $catNames = ['Laptop','Màn hình','Điện thoại','Chuột + Lót chuột','Tai nghe'];
        $catIds = [];
        foreach ($catNames as $c) {
            DB::table('categories')->updateOrInsert(
                ['name'=>$c],
                ['slug'=>Str::slug($c), 'parent_id'=>null, 'is_active'=>1]
            );
            $catIds[$c] = (int) DB::table('categories')->where('name',$c)->value('id');
        }

        // ===== 1) Bộ series theo brand (để tên sản phẩm nhìn “đúng chất”) =====
        $series = [
            'ASUS'   => ['Vivobook','Zenbook','TUF Gaming','ROG Strix'],
            'ACER'   => ['Aspire','Swift','Nitro'],
            'MSI'    => ['Modern','Prestige','GF Series','Katana'],
            'LENOVO' => ['IdeaPad','ThinkBook','Legion'],
            'DELL'   => ['Inspiron','Vostro','G Series'],
            'HP'     => ['Pavilion','Victus','Envy'],
            'LG'     => ['Gram'],
        ];

        // CPU tags để thêm vào tên/tags
        $cpus = ['Intel Core i3','Intel Core i5','Intel Core i7','AMD Ryzen 5','AMD Ryzen 7'];

        // Price buckets (nghìn VND)
        $buckets = [
            'under15' => [ 8_000_000, 14_900_000 ],
            '15to20'  => [15_000_000, 19_900_000 ],
            'over20'  => [20_000_000, 39_900_000 ],
        ];

        // Helper sinh giá theo bucket
        $randPrice = function(array $range) {
            [$min, $max] = $range;
            $step = 500_000;
            $steps = intdiv($max - $min, $step);
            return $min + (random_int(0, max(1,$steps)) * $step);
        };

        // ===== 2) Sinh 20 sản phẩm cho mỗi danh mục =====
        $perCategory = 20;

        foreach ($catIds as $catName => $categoryId) {
            for ($i=1; $i<=$perCategory; $i++) {

                // chọn brand hợp lý theo danh mục (vẫn dùng 7 brand sẵn có)
                $brand = array_rand($brandIds);
                // chọn series nếu có
                $seriesName = $series[$brand][array_rand($series[$brand])];

                // CPU và bucket giá
                $cpu = $cpus[array_rand($cpus)];

                // quy ước: cứ 1/3 sản phẩm cho mỗi bucket
                $bucketKey = ['under15','15to20','over20'][$i % 3];
                $price = $randPrice($buckets[$bucketKey]);
                $oldPrice = (random_int(0,1) ? $price + 500_000 : null);

                // tên sản phẩm
                $modelCode = strtoupper(Str::random(4)) . '-' . random_int(100,999);
                $name = match ($catName) {
                    'Laptop'              => "{$brand} {$seriesName} {$modelCode} - {$cpu} - RAM 16GB - SSD 512GB",
                    'Màn hình'            => "{$brand} {$seriesName} {$modelCode} - 27\" IPS 165Hz",
                    'Điện thoại'          => "{$brand} {$seriesName} {$modelCode} - 8GB/256GB",
                    'Chuột + Lót chuột'   => "{$brand} {$seriesName} {$modelCode} - Gaming Mouse",
                    'Tai nghe'            => "{$brand} {$seriesName} {$modelCode} - Wireless Headset",
                    default               => "{$brand} {$seriesName} {$modelCode}",
                };

                $slug = Str::slug($name.'-'.$categoryId.'-'.$i);

                // image (placeholder ổn định theo slug)
                $img  = "https://picsum.photos/seed/{$slug}/600/600";
                $gal1 = "https://picsum.photos/seed/{$slug}-1/600/600";
                $gal2 = "https://picsum.photos/seed/{$slug}-2/600/600";

                // tags/attributes
                $tags = implode(',', [
                    $brand, $seriesName, $cpu,
                    ($catName==='Màn hình' ? '165Hz' : 'SSD'),
                ]);

                $attributes = [];
                if ($catName === 'Laptop') {
                    $attributes = [
                        'cpu' => $cpu,
                        'ram' => '16GB',
                        'storage' => '512GB SSD',
                        'gpu' => (str_contains($seriesName,'TUF') || str_contains($seriesName,'Legion') || str_contains($seriesName,'G '))
                            ? 'RTX 3050' : 'Integrated',
                        'weight' => (random_int(12,20)/10) . 'kg',
                    ];
                } elseif ($catName === 'Màn hình') {
                    $attributes = [
                        'panel' => 'IPS',
                        'size' => '27 inch',
                        'refresh_rate' => '165Hz',
                        'resolution' => '2560x1440',
                    ];
                } elseif ($catName === 'Điện thoại') {
                    $attributes = [
                        'ram' => '8GB',
                        'storage' => '256GB',
                        'battery' => '5000mAh',
                        'display' => 'AMOLED 6.7"',
                    ];
                } elseif ($catName === 'Chuột + Lót chuột') {
                    $attributes = [
                        'dpi' => '12,000',
                        'connection' => 'Wired',
                        'switch' => 'Omron',
                    ];
                } elseif ($catName === 'Tai nghe') {
                    $attributes = [
                        'type' => 'Over-ear',
                        'connection' => 'Wireless',
                        'mic' => true,
                    ];
                }

                // insert / updateOrInsert để tránh trùng slug nếu chạy nhiều lần
                DB::table('products')->updateOrInsert(
                    ['slug' => $slug],
                    [
                        'name'        => $name,
                        'brand_id'    => $brandIds[$brand],
                        'category_id' => $categoryId,
                        'price'       => $price,
                        'old_price'   => $oldPrice,
                        'stock'       => random_int(5, 50),
                        'image'       => $img,
                        'gallery'     => json_encode([$img, $gal1, $gal2]),
                        'tags'        => $tags,
                        'attributes'  => json_encode($attributes),
                        'is_active'   => 1,
                        'updated_at'  => now(),
                        'created_at'  => now(),
                    ]
                );
            }
        }

        // ===== 3) (tuỳ chọn) Tạo product_images từ gallery =====
        if (Schema::hasTable('product_images')) {
            $rows = DB::table('products')->select('id','gallery','slug')->get();
            foreach ($rows as $r) {
                $gallery = $r->gallery ? json_decode($r->gallery, true) : [];
                $order = 0;
                foreach ($gallery as $idx => $url) {
                    DB::table('product_images')->updateOrInsert(
                        ['product_id'=>$r->id, 'url'=>$url],
                        ['sort_order'=>$order++, 'is_primary'=>($idx===0), 'created_at'=>now(),'updated_at'=>now()]
                    );
                }
            }
        }
    }
}
