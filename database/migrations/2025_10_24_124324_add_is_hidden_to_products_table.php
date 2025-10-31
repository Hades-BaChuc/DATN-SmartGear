<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // chọn cột để đặt AFTER nếu tồn tại
            $after = null;
            if (Schema::hasColumn('products', 'product_name')) {
                $after = 'product_name';
            } elseif (Schema::hasColumn('products', 'name')) {
                $after = 'name';
            }

            if (!Schema::hasColumn('products', 'is_hidden')) {
                $col = $table->boolean('is_hidden')->default(false);
                if ($after) {
                    $col->after($after);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_hidden')) {
                $table->dropColumn('is_hidden');
            }
        });
    }
};
