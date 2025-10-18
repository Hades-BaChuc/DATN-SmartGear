<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    if (!Schema::hasTable('product_images')) {
      Schema::create('product_images', function (Blueprint $t) {
        $t->id();
        $t->unsignedBigInteger('product_id')->index();
        $t->string('url');
        $t->boolean('is_primary')->default(false);
        $t->unsignedSmallInteger('sort_order')->default(0);
        $t->timestamps();
      });
    }
  }
  public function down(): void {
    Schema::dropIfExists('product_images');
  }
};
