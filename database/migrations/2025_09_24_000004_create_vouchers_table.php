<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vouchers', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();                    // mã giảm giá
            $t->enum('type', ['percent','fixed'])->default('percent');
            $t->unsignedInteger('value');                    // % hoặc số tiền
            $t->unsignedInteger('min_order_total')->nullable();
            $t->unsignedInteger('max_discount')->nullable();
            $t->timestamp('start_at')->nullable();
            $t->timestamp('end_at')->nullable();
            $t->unsignedInteger('quota')->nullable();        // số lần dùng
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('vouchers');
    }
};
