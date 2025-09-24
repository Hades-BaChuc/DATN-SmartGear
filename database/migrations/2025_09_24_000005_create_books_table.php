<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('isbn')->nullable()->unique();
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->string('format')->nullable();
            $table->string('language', 32)->default('vi');
            $table->unsignedInteger('pages')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->string('size')->nullable();
            $table->year('publish_year')->nullable();
            $table->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft','active','hidden'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('books');
    }
};
