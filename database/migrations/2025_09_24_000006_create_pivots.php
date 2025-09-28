<?php

// database/migrations/2025_09_24_000006_create_pivots.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';              // phòng khi engine mặc định không phải InnoDB
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(['book_id','category_id']);
            // TẠM THỜI: không add ->foreign() ở đây
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_category');
    }
};
