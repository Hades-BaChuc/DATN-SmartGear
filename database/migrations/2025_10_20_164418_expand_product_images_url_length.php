<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Cách 1: dùng change() (cần doctrine/dbal)
        try {
            Schema::table('product_images', function (Blueprint $table) {
                $table->string('url', 2048)->change();
            });
        } catch (\Throwable $e) {
            // Cách 2: fall-back raw SQL (MySQL/Laragon)
            if (DB::getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE product_images MODIFY url VARCHAR(2048)');
            } else {
                throw $e;
            }
        }
    }

    public function down(): void
    {
        try {
            Schema::table('product_images', function (Blueprint $table) {
                $table->string('url', 255)->change();
            });
        } catch (\Throwable $e) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE product_images MODIFY url VARCHAR(255)');
            } else {
                throw $e;
            }
        }
    }
};
