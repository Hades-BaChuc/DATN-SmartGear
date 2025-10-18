<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $t) {
            if (!Schema::hasColumn('products','brand_id')) {
                $t->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete()->after('id');
            }
            if (!Schema::hasColumn('products','category_id')) {
                $t->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->after('brand_id');
            }
            if (!Schema::hasColumn('products','image_url')) {
                $t->string('image_url', 2048)->nullable()->after('slug');
            }
            if (!Schema::hasColumn('products','short_specs')) {
                $t->string('short_specs', 255)->nullable()->after('image_url');
            }
        });
    }
    public function down(): void {
        Schema::table('products', function (Blueprint $t) {
            if (Schema::hasColumn('products','short_specs')) $t->dropColumn('short_specs');
            if (Schema::hasColumn('products','image_url'))  $t->dropColumn('image_url');
            if (Schema::hasColumn('products','category_id')) $t->dropConstrainedForeignId('category_id');
            if (Schema::hasColumn('products','brand_id'))    $t->dropConstrainedForeignId('brand_id');
        });
    }
};
