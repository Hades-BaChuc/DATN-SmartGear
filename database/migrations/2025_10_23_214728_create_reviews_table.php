<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('reviews', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->tinyInteger('rating');               // 1..5
            $t->text('content')->nullable();
            $t->timestamps();
            $t->unique(['user_id','product_id']);    // 1 user / 1 sp / 1 review
        });
    }
    public function down(){ Schema::dropIfExists('reviews'); }
};
