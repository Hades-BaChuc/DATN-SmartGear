<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    // Số sản phẩm mỗi danh mục con
    private int $PER_CATEGORY = 20;

    public function run(): void
    {
        DB::beginTransaction();

        // ---- BRANDS (tên giống giao diện) ----
        $brands = [
            ['name'=>'ASUS'], ['name'=>'ACER'], ['name'=>'MSI'], ['name'=>'LENOVO'],
            ['name'=>'DELL'], ['name'=>'HP'], ['name'=>'LG'],
            // phụ kiện / điện thoại
            ['name'=>'LOGITECH'], ['name'=>'RAZER'], ['name'=>'STEELSERIES'],
            ['name'=>'HYPERX'], ['name'=>'SONY'], ['name'=>'SAMSUNG'], ['name'=>'APPLE'], ['name'=>'XIAOMI'],
            ['name'=>'AOC'], ['name'=>'GIGABYTE'], ['name'=>'VIEWSONIC'], ['name'=>'PHILIPS'],
        ];
        $brandIds = [];
        foreach ($brands as $b) {
            $slug = Str::slug($b['name']);
            $id = DB::table('brands')->updateOrInsert(
                ['name' => $b['name']],
                ['slug' => $slug, 'logo_url'=>null, 'is_featured'=>1, 'updated_at'=>now(), 'created_at'=>now()]
            );
            // re-query id (updateOrInsert không trả id)
            $brandIds[$b['name']] = DB::table('brands')->where('name',$b['name'])->value('id');
        }

        // ---- CATEGORIES (menu bên trái) ----
        $cats = [
            'Laptop' => [
                'Laptop ASUS' => ['Vivobook Series','Zenbook Series','TUF Gaming'],
                'Laptop ACER' => ['Aspire Series','Swift Series'],
                'Laptop MSI'  => ['Modern Series','Gaming GF Series'],
                'Laptop LENOVO' => ['IdeaPad Series','Legion Series'],
                'Laptop DELL' => ['Inspiron Series','XPS Series'],
                'Laptop HP'   => ['Pavilion Series','Victus Series'],
                'Laptop LG'   => ['Gram Series'],
            ],
            'Màn hình' => [
                'ASUS TUF' => ['VG247','VG27AQ'],
                'LG UltraGear' => ['24GN600','27GP850'],
                'DELL' => ['P2419H','S2721D'],
                'MSI' => ['G2412','MAG274'],
                'AOC' => ['24G2','27G2'],
                'GIGABYTE' => ['G24F','M27Q'],
                'VIEWSONIC' => ['VX2458','XG2705'],
                'PHILIPS' => ['241V8','275M1'],
            ],
            'Điện thoại' => [
                'Apple iPhone' => ['iPhone 13','iPhone 14','iPhone 15'],
                'Samsung Galaxy' => ['S22','S23','A34','A54'],
                'Xiaomi Redmi' => ['Note 11','Note 12','Note 13'],
            ],
            'Chuột + Lót chuột' => [
                'Chuột Logitech' => ['G102','G304','G Pro X Superlight'],
                'Chuột Razer' => ['DeathAdder V2','Viper Mini','Basilisk V3'],
                'Chuột SteelSeries' => ['Rival 3','Aerox 3','Prime'],
                'Lót chuột' => ['Razer Gigantus','Logitech G840','SteelSeries QcK'],
            ],
            'Tai nghe' => [
                'HyperX' => ['Cloud II','Cloud Alpha','Stinger'],
                'Razer' => ['Kraken','BlackShark V2','Barracuda'],
                'Sony' => ['WH-1000XM4','WH-1000XM5','INZONE H7'],
                'Logitech' => ['G435','G733','Pro X'],
            ],
        ];

        $catIds = [];
        foreach ($cats as $parent => $groups) {
            $parentId = $this->catUpsert($parent, null);
            foreach ($groups as $group => $children) {
                $groupId = $this->catUpsert($group, $parentId);
                foreach ($children as $child) {
                    $leafId = $this->catUpsert($child, $groupId);
                    $catIds[] = $leafId;
                }
            }
        }

        // ---- TẠO 20 SP CHO MỖI DANH MỤC CON ----
        foreach ($cats as $parent => $groups) {
            foreach ($groups as $group => $children) {
                foreach ($children as $child) {
                    $leafId = DB::table('categories')->where('slug', Str::slug($child))->value('id');
                    $this->seedProductsForLeaf($parent, $group, $child, $leafId, $brandIds, $this->PER_CATEGORY);
                }
            }
        }

        DB::commit();
    }

    private function catUpsert(string $name, ?int $parentId): int
    {
        $slug = Str::slug($name);
        DB::table('categories')->updateOrInsert(
            ['slug'=>$slug],
            ['name'=>$name, 'parent_id'=>$parentId, 'is_active'=>1, 'updated_at'=>now(), 'created_at'=>now()]
        );
        return (int) DB::table('categories')->where('slug',$slug)->value('id');
    }

    private function seedProductsForLeaf(
        string $parent, string $group, string $leaf, int $categoryId, array $brandIds, int $count
    ): void {
        // chọn brand theo group/leaf nếu match, mặc định ASUS
        $brandNameGuess = 'ASUS';
        foreach (array_keys($brandIds) as $bName) {
            if (stripos($group.' '.$leaf, $bName) !== false) { $brandNameGuess = $bName; break; }
        }
        $brandId = $brandIds[$brandNameGuess] ?? reset($brandIds);

        // preset giá theo “nhóm”
        [$min, $max] = match ($parent) {
            'Màn hình' => [2500000, 12000000],
            'Chuột + Lót chuột' => [150000, 3000000],
            'Tai nghe' => [300000, 6000000],
            'Điện thoại' => [3500000, 30000000],
            default => [9000000, 45000000], // Laptop
        };

        for ($i=1; $i<=$count; $i++) {
            $name = $this->fakeName($parent, $group, $leaf, $i);
            $slug = Str::slug($name.'-'.$categoryId.'-'.$i);
            $price = $this->randInt($min, $max);
            $old  = (rand(0,1) ? $price + $this->randInt(300000, 2000000) : null);
            $stock = $this->randInt(3, 30);
            $image = "https://picsum.photos/seed/{$slug}/600/400";
            $gallery = [
                "https://picsum.photos/seed/{$slug}a/800/600",
                "https://picsum.photos/seed/{$slug}b/800/600",
                "https://picsum.photos/seed/{$slug}c/800/600",
            ];
            $tags = $this->tagsFor($parent, $group, $leaf);

            DB::table('products')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name'        => $name,
                    'brand_id'    => $brandId,
                    'category_id' => $categoryId,
                    'price'       => $price,
                    'old_price'   => $old,
                    'stock'       => $stock,
                    'image'       => $image,
                    'gallery'     => json_encode($gallery),
                    'tags'        => implode(',', $tags),
                    'attributes'  => json_encode($this->attributesFor($parent, $tags)),
                    'is_active'   => 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }

    private function fakeName(string $parent, string $group, string $leaf, int $i): string
    {
        // Tên sản phẩm giống “GearVN style”
        if ($parent === 'Laptop') {
            $cpu = ['i3','i5','i7','Ryzen 5','Ryzen 7'][array_rand([0,1,2,3,4])];
            $ram = [8,16,32][array_rand([0,1,2])];
            $ssd = [256,512,1024][array_rand([0,1,2])];
            return "{$leaf} {$cpu} {$ram}GB {$ssd}GB - M{$i}";
        }
        if ($parent === 'Màn hình') {
            $size = [23.8,24,27,29,32][array_rand([0,1,2,3,4])];
            $hz = [75,120,144,165,240][array_rand([0,1,2,3,4])];
            return "{$leaf} {$size}\" {$hz}Hz - D{$i}";
        }
        if ($parent === 'Điện thoại') {
            $ram = [6,8,12][array_rand([0,1,2])];
            $rom = [128,256,512][array_rand([0,1,2])];
            return "{$leaf} ({$ram}GB/{$rom}GB) - P{$i}";
        }
        if ($parent === 'Chuột + Lót chuột') {
            return "{$leaf} - G{$i}";
        }
        if ($parent === 'Tai nghe') {
            return "{$leaf} - H{$i}";
        }
        return "{$leaf} - X{$i}";
    }

    private function tagsFor(string $parent, string $group, string $leaf): array
    {
        $common = ['chinh-hang','bao-hanh-12-thang'];
        return match ($parent) {
            'Laptop' => array_merge($common, ['laptop','hoc-tap','van-phong','gaming']),
            'Màn hình' => array_merge($common, ['monitor','IPS','144hz']),
            'Điện thoại' => array_merge($common, ['smartphone','4g','5g']),
            'Chuột + Lót chuột' => array_merge($common, ['mouse','pad','gaming']),
            'Tai nghe' => array_merge($common, ['headset','micro','gaming']),
            default => $common,
        };
    }

    private function attributesFor(string $parent, array $tags): array
    {
        return match ($parent) {
            'Laptop' => [
                'cpu' => ['Intel i3','Intel i5','Intel i7','AMD Ryzen 5','AMD Ryzen 7'][rand(0,4)],
                'ram' => [8,16,32][rand(0,2)] . ' GB',
                'storage' => [256,512,1024][rand(0,2)] . ' GB SSD',
                'gpu' => ['iGPU','RTX 3050','RTX 4050','RTX 4060'][rand(0,3)],
                'os' => ['Windows 11','Windows 10'][rand(0,1)],
            ],
            'Màn hình' => [
                'panel' => ['IPS','VA','TN'][rand(0,2)],
                'refresh_rate' => [75,120,144,165,240][rand(0,4)] . ' Hz',
                'size' => [23.8,24,27,32][rand(0,3)] . ' inch',
                'resolution' => ['FHD','QHD','4K'][rand(0,2)],
            ],
            'Điện thoại' => [
                'chip' => ['A16 Bionic','A17 Pro','Snapdragon 8 Gen 2','Dimensity 1080'][rand(0,3)],
                'ram' => [6,8,12][rand(0,2)] . ' GB',
                'storage' => [128,256,512][rand(0,2)] . ' GB',
                'battery' => [4000,4500,5000][rand(0,2)] . ' mAh',
            ],
            'Chuột + Lót chuột' => [
                'type' => ['mouse','mousepad'][rand(0,1)],
                'dpi'  => [8000,12000,26000][rand(0,2)],
                'connection' => ['wired','wireless'][rand(0,1)],
            ],
            'Tai nghe' => [
                'type' => ['over-ear','in-ear'][rand(0,1)],
                'connection' => ['wired','bluetooth'][rand(0,1)],
                'mic' => (bool)rand(0,1),
            ],
            default => [],
        };
    }

    private function randInt(int $min, int $max): int
    {
        return (int) (round(mt_rand($min, $max) / 1000) * 1000); // làm tròn nghìn cho đẹp
    }
}
