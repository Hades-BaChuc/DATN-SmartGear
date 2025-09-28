<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();

            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->unsignedInteger('stock')->default(0);

            // --- các field công nghệ ---
            $table->string('model')->nullable();
            $table->year('release_year')->nullable();
            $table->unsignedInteger('warranty_months')->nullable();

            // --- FK đúng cú pháp ---
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();

            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft','active','hidden'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
