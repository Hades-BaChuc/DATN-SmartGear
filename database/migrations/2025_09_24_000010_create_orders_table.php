<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('code')->unique();
            $t->unsignedInteger('subtotal');
            $t->unsignedInteger('discount_total')->default(0);
            $t->unsignedInteger('shipping_fee')->default(0);
            $t->unsignedInteger('grand_total');
            $t->enum('payment_method',['vnpay','momo','cod','stripe'])->default('cod');
            $t->enum('payment_status',['pending','paid','failed','refunded'])->default('pending');
            $t->enum('shipping_status',['new','processing','shipped','delivered','cancelled'])->default('new');

            // CHỈ tạo cột, chưa thêm FK
            $t->foreignId('address_id');

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
