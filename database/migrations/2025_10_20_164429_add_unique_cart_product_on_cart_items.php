<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Xác định tên cột thực tế
        $qtyCol   = Schema::hasColumn('cart_items', 'qty')         ? 'qty'
            : (Schema::hasColumn('cart_items', 'quantity')   ? 'quantity' : null);

        $priceCol = Schema::hasColumn('cart_items', 'price')       ? 'price'
            : (Schema::hasColumn('cart_items', 'unit_price') ? 'unit_price' : null);

        $lineCol  = Schema::hasColumn('cart_items', 'line_total')  ? 'line_total'
            : (Schema::hasColumn('cart_items', 'total_price')? 'total_price' : null);

        // Gộp các dòng trùng (cart_id + product_id)
        $dups = DB::table('cart_items')
            ->select('cart_id','product_id', DB::raw('COUNT(*) AS c'))
            ->groupBy('cart_id','product_id')
            ->having('c','>',1)
            ->get();

        foreach ($dups as $g) {
            $rows = DB::table('cart_items')
                ->where('cart_id', $g->cart_id)
                ->where('product_id', $g->product_id)
                ->orderBy('id')
                ->get();

            if ($rows->count() < 2) continue;

            $keep   = $rows->first();
            $sumQty = 0;
            $maxPrice = 0;
            $sumLine = 0;

            foreach ($rows as $r) {
                $q = $qtyCol   ? (int) $r->{$qtyCol}   : 1;
                $p = $priceCol ? (int) $r->{$priceCol} : 0;
                $l = $lineCol  ? (int) $r->{$lineCol}  : ($q * $p);

                $sumQty  += $q;
                $maxPrice = max($maxPrice, $p);
                $sumLine += $l;
            }

            $update = [];
            if ($qtyCol)   $update[$qtyCol]   = $sumQty;
            if ($priceCol) $update[$priceCol] = $maxPrice;
            if ($lineCol)  $update[$lineCol]  = $sumLine;

            if ($update) {
                DB::table('cart_items')->where('id', $keep->id)->update($update);
            }

            DB::table('cart_items')
                ->where('cart_id', $g->cart_id)
                ->where('product_id', $g->product_id)
                ->where('id', '<>', $keep->id)
                ->delete();
        }

        // Thêm UNIQUE sau khi đã dọn trùng
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unique(['cart_id','product_id'], 'ci_cart_product_unique');
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique('ci_cart_product_unique');
        });
    }
};
