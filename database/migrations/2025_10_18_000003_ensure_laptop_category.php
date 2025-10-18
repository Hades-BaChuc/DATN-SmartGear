<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void {
        $exists = DB::table('categories')->where('slug','laptop')->first();
        if (!$exists) {
            DB::table('categories')->insert([
                'name' => 'Laptop',
                'slug' => 'laptop',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    public function down(): void {
        // không xóa để tránh mất dữ liệu
    }
};
