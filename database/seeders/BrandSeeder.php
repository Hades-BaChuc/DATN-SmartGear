<?php
namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['ASUS','ACER','MSI','LENOVO','DELL','HP','LG','Apple'];
        foreach ($names as $n) {
            Brand::firstOrCreate(
                ['slug' => Str::slug($n)],
                ['name' => $n]
            );
        }
    }
}
