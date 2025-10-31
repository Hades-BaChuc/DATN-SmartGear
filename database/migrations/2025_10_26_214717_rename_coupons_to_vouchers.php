<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Đổi tên bảng
        if (Schema::hasTable('coupons') && !Schema::hasTable('vouchers')) {
            Schema::rename('coupons', 'vouchers');
        }

        // Nếu đơn hàng đang lưu coupon_id -> đổi sang voucher_id
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'coupon_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('coupon_id', 'voucher_id'); // cần doctrine/dbal
            });
        }

        // Nếu đơn hàng đang lưu coupon_code -> đổi sang voucher_code
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'coupon_code') && !Schema::hasColumn('orders','voucher_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('coupon_code', 'voucher_code');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vouchers')) {
            Schema::rename('vouchers', 'coupons');
        }
        if (Schema::hasTable('orders') && Schema::hasColumn('orders','voucher_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('voucher_id', 'coupon_id');
            });
        }
        if (Schema::hasTable('orders') && Schema::hasColumn('orders','voucher_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('voucher_code', 'coupon_code');
            });
        }
    }
};
