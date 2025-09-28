<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->id();
            $t->foreignId('cart_id')->constrained('carts')->cascadeOnDelete();
            $t->foreignId('book_id')->constrained('products')->cascadeOnDelete(); // nếu bạn cần
            $t->unsignedInteger('qty')->default(1);
            $t->unsignedInteger('price')->nullable(); // nếu tính giá tại thời điểm thêm
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cart_items');
    }
};
