<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <— thêm dòng này

return new class extends Migration {
  public function up(): void {
    Schema::table('products', function (Blueprint $t) {
      if (!Schema::hasColumn('products','slug')) $t->string('slug')->unique()->after('name');
      if (!Schema::hasColumn('products','brand_id')) $t->unsignedBigInteger('brand_id')->nullable()->index()->after('slug');
      if (!Schema::hasColumn('products','category_id')) $t->unsignedBigInteger('category_id')->nullable()->index()->after('brand_id');

      if (!Schema::hasColumn('products','price')) $t->unsignedInteger('price')->default(0)->after('category_id');
      if (!Schema::hasColumn('products','old_price')) $t->unsignedInteger('old_price')->nullable()->after('price');
      if (!Schema::hasColumn('products','stock')) $t->unsignedInteger('stock')->default(0)->after('old_price');

      if (!Schema::hasColumn('products','image')) $t->string('image')->nullable()->after('stock');
      if (!Schema::hasColumn('products','gallery')) $t->json('gallery')->nullable()->after('image');

      if (!Schema::hasColumn('products','tags')) $t->string('tags')->nullable()->after('gallery');
      if (!Schema::hasColumn('products','attributes')) $t->json('attributes')->nullable()->after('tags');

      // Thêm cột is_active nếu chưa có
      if (!Schema::hasColumn('products', 'is_active')) {
        $t->boolean('is_active')->default(true)->after('attributes');
      }
    });

    // TẠO INDEX CHỈ KHI CHƯA TỒN TẠI
    // price
    $hasPriceIdx = collect(DB::select("SHOW INDEX FROM products WHERE Key_name = 'products_price_index'"))->isNotEmpty();
    if (!$hasPriceIdx && Schema::hasColumn('products','price')) {
      Schema::table('products', fn (Blueprint $t) => $t->index('price', 'products_price_index'));
    }

    // is_active
    if (Schema::hasColumn('products','is_active')) {
      $hasActiveIdx = collect(DB::select("SHOW INDEX FROM products WHERE Key_name = 'products_is_active_index'"))->isNotEmpty();
      if (!$hasActiveIdx) {
        Schema::table('products', fn (Blueprint $t) => $t->index('is_active', 'products_is_active_index'));
      }
    }
  }

  public function down(): void {
    // Gỡ index nếu có, rồi drop cột bổ sung
    $hasPriceIdx = collect(DB::select("SHOW INDEX FROM products WHERE Key_name = 'products_price_index'"))->isNotEmpty();
    if ($hasPriceIdx) {
      Schema::table('products', fn (Blueprint $t) => $t->dropIndex('products_price_index'));
    }
    $hasActiveIdx = collect(DB::select("SHOW INDEX FROM products WHERE Key_name = 'products_is_active_index'"))->isNotEmpty();
    if ($hasActiveIdx) {
      Schema::table('products', fn (Blueprint $t) => $t->dropIndex('products_is_active_index'));
    }

    Schema::table('products', function (Blueprint $t) {
      foreach (['is_active','attributes','tags','gallery','image','stock','old_price','price','category_id','brand_id','slug'] as $c) {
        if (Schema::hasColumn('products',$c)) $t->dropColumn($c);
      }
    });
  }
};
