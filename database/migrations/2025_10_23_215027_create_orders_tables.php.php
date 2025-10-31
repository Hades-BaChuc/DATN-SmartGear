<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('full_name');
            $t->string('phone',20);
            $t->string('email')->nullable();
            $t->text('address_text');                   // snapshot địa chỉ
            $t->unsignedInteger('subtotal');            // tạm tính
            $t->unsignedInteger('shipping_fee')->default(0);
            $t->unsignedInteger('discount')->default(0);
            $t->unsignedInteger('total');               // phải trả
            $t->string('coupon_code')->nullable();
            $t->enum('payment_method',['cod'])->default('cod');
            $t->enum('status',['pending','confirmed','shipping','done','cancel'])->default('pending');
            $t->timestamps();
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->restrictOnDelete();
            $t->string('name');
            $t->unsignedInteger('price');          // snapshot giá tại thời điểm đặt
            $t->unsignedInteger('qty');
            $t->string('image_url')->nullable();
            $t->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('order_items'); Schema::dropIfExists('orders'); }
};
