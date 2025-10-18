<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('categories', function (Blueprint $t) {
      if (!Schema::hasColumn('categories','parent_id')) $t->unsignedBigInteger('parent_id')->nullable()->index()->after('id');
      if (!Schema::hasColumn('categories','slug')) $t->string('slug')->unique()->after('name');
      if (!Schema::hasColumn('categories','icon')) $t->string('icon')->nullable()->after('slug');
      if (!Schema::hasColumn('categories','is_active')) $t->boolean('is_active')->default(true)->after('icon');
      // foreign key mềm (tránh lỗi nếu data sẵn): có thể bỏ nếu bạn muốn strict
      // $t->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
    });
  }
  public function down(): void {
    Schema::table('categories', function (Blueprint $t) {
      foreach (['is_active','icon','slug','parent_id'] as $c) {
        if (Schema::hasColumn('categories',$c)) $t->dropColumn($c);
      }
    });
  }
};


