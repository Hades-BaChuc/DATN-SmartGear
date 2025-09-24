<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // BẢO HIỂM: nếu còn bảng cũ thì xoá trước khi tạo lại
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('book_category');

        Schema::create('book_category', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('category_id')->constrained()->cascadeOnDelete();
            $t->primary(['book_id','category_id']);
        });

        Schema::create('book_author', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('author_id')->constrained()->cascadeOnDelete();
            $t->primary(['book_id','author_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('book_category');
    }
};
