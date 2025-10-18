<?php

// database/migrations/xxxx_update_brands_table_for_ui.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('brands', function (Blueprint $t) {
      if (!Schema::hasColumn('brands','slug')) $t->string('slug')->unique()->after('name');
      if (!Schema::hasColumn('brands','logo_url')) $t->string('logo_url')->nullable()->after('slug');
      if (!Schema::hasColumn('brands','is_featured')) $t->boolean('is_featured')->default(false)->after('logo_url');
    });
  }
  public function down(): void {
    Schema::table('brands', function (Blueprint $t) {
      if (Schema::hasColumn('brands','is_featured')) $t->dropColumn('is_featured');
      if (Schema::hasColumn('brands','logo_url')) $t->dropColumn('logo_url');
      if (Schema::hasColumn('brands','slug')) $t->dropColumn('slug');
    });
  }
};
