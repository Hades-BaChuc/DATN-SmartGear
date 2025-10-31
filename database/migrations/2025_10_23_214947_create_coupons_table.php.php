<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('coupons', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->enum('type',['percent','fixed']);
            $t->unsignedInteger('amount');          // % hoặc số tiền (đ)
            $t->boolean('active')->default(true);
            $t->timestamp('starts_at')->nullable();
            $t->timestamp('ends_at')->nullable();
            $t->unsignedInteger('usage_limit')->nullable();  // tổng số lần
            $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('coupons'); }
};
