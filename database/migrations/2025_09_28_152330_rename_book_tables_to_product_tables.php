<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Nếu có books mà chưa có products thì rename
        if (!Schema::hasTable('products') && Schema::hasTable('books')) {
            Schema::rename('books', 'products');
        }

        // Chuẩn hoá bảng products (đổi/ thêm cột). KHÔNG introspect Doctrine
        if (Schema::hasTable('products')) {
    Schema::table('products', function (Blueprint $table) {
        // Đổi cột sách -> sản phẩm (nếu tồn tại)
        if (Schema::hasColumn('products','title') && !Schema::hasColumn('products','name')) {
            $table->renameColumn('title', 'name');
        }
        if (Schema::hasColumn('products','isbn') && !Schema::hasColumn('products','sku')) {
            $table->renameColumn('isbn', 'sku');
        }

        // Nếu còn publisher_id thì đổi tên sang supplier_id
        if (Schema::hasColumn('products','publisher_id') && !Schema::hasColumn('products','supplier_id')) {
            $table->renameColumn('publisher_id', 'supplier_id');
        }

        // Bổ sung cột công nghệ nếu thiếu
        if (!Schema::hasColumn('products','model')) $table->string('model')->nullable()->after('name');
        if (Schema::hasColumn('products','published_year') && !Schema::hasColumn('products','release_year')) {
            $table->renameColumn('published_year', 'release_year');
        }
        if (Schema::hasColumn('products','publish_year') && !Schema::hasColumn('products','release_year')) {
            $table->renameColumn('publish_year', 'release_year');
        }
        if (Schema::hasColumn('products','pages') && !Schema::hasColumn('products','warranty_months')) {
            $table->integer('warranty_months')->nullable();
        }

        // Bảo đảm có 2 cột FK
        if (!Schema::hasColumn('products','brand_id'))    $table->unsignedBigInteger('brand_id')->nullable();
        if (!Schema::hasColumn('products','supplier_id')) $table->unsignedBigInteger('supplier_id')->nullable();
    });
}

        // Pivot: book_category -> product_category
        if (Schema::hasTable('book_category')) {
            Schema::rename('book_category', 'product_category');

            Schema::table('product_category', function (Blueprint $table) {
                if (Schema::hasColumn('product_category','book_id')) {
                    $table->renameColumn('book_id', 'product_id');
                }
                $table->index('product_id');
                $table->index('category_id');
            });

            Schema::table('product_category', function (Blueprint $table) {
                try { $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete(); } catch (\Throwable $e) {}
                try { $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete(); } catch (\Throwable $e) {}
            });
        }

        // author_book -> brand_product (nếu có)
        if (Schema::hasTable('author_book')) {
            Schema::rename('author_book', 'brand_product');
            Schema::table('brand_product', function (Blueprint $table) {
                if (Schema::hasColumn('brand_product','book_id'))   $table->renameColumn('book_id', 'product_id');
                if (Schema::hasColumn('brand_product','author_id')) $table->renameColumn('author_id', 'brand_id');
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // Tháo FK ở pivot
        if (Schema::hasTable('product_category')) {
            Schema::table('product_category', function (Blueprint $table) {
                try { $table->dropForeign(['product_id']); } catch (\Throwable $e) {}
                try { $table->dropForeign(['category_id']); } catch (\Throwable $e) {}
            });
            Schema::rename('product_category', 'book_category');
        }

        // Tháo FK ở products rồi rename lại books
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                try { $table->dropForeign(['brand_id']); } catch (\Throwable $e) {}
                try { $table->dropForeign(['supplier_id']); } catch (\Throwable $e) {}
            });
            if (!Schema::hasTable('books')) {
                Schema::rename('products', 'books');
            }
        }

        Schema::enableForeignKeyConstraints();
    }
};
