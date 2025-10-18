<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $t) {
            if (!Schema::hasColumn('cart_items', 'unit_price')) {
                if (Schema::hasColumn('cart_items', 'qty')) {
                    $t->unsignedInteger('unit_price')->default(0)->after('qty');
                } elseif (Schema::hasColumn('cart_items', 'quantity')) {
                    $t->unsignedInteger('unit_price')->default(0)->after('quantity');
                } else {
                    // Không xác định được cột đứng trước -> thêm ở cuối bảng
                    $t->unsignedInteger('unit_price')->default(0);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $t) {
            if (Schema::hasColumn('cart_items', 'unit_price')) {
                $t->dropColumn('unit_price');
            }
        });
    }
};
