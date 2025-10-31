<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Arr;

class CartService
{
    const KEY = 'cart';

    protected function data(): array
    {
        return session(self::KEY, ['items' => [], 'coupon' => null]);
    }

    protected function save(array $data): void
    {
        // nếu giỏ trống thì bỏ luôn coupon
        if (empty($data['items'])) {
            $data['coupon'] = null;
        }
        session([self::KEY => $data]);
        session()->save();
    }

    // ================== getters ==================
    public function all(): array
    {
        return $this->data();
    }

    public function items(): array
    {
        return array_values($this->data()['items']);
    }

    public function count(): int
    {
        return array_sum(array_map(fn ($i) => (int)$i['qty'], $this->items()));
    }

    public function coupon(): ?Coupon
    {
        $code = $this->data()['coupon'] ?? null;
        if (!$code) return null;
        return Coupon::where('code', $code)->first();
    }

    public function subtotal(): int
    {
        return array_reduce($this->items(), function ($carry, $i) {
            return $carry + ((int)$i['price'] * (int)$i['qty']);
        }, 0);
    }

    public function discount(): int
    {
        $coupon = $this->coupon();
        if (!$coupon || !$coupon->isValid()) return 0;

        $sub = $this->subtotal();
        if ($coupon->min_order && $sub < (int)$coupon->min_order) {
            return 0;
        }

        $value = (int)$coupon->value;
        $discount = $coupon->type === 'percent'
            ? (int) round($sub * $value / 100)
            : $value;

        if (!empty($coupon->max_discount)) {
            $discount = min($discount, (int)$coupon->max_discount);
        }
        return min($discount, $sub);
    }

    public function shippingFee(): int
    {
        // phí ship cơ bản + miễn phí nếu đạt ngưỡng
        $base     = (int) config('shop.shipping_base', 30000);
        $freeFrom = (int) config('shop.shipping_free_from', 2000000);
        return $this->subtotal() >= $freeFrom ? 0 : $base;
    }

    public function totals(): array
    {
        $subtotal = $this->subtotal();
        $shipping = $this->shippingFee();
        $discount = $this->discount();
        $total    = max(0, $subtotal + $shipping - $discount);

        return compact('subtotal', 'shipping', 'discount', 'total');
    }

    // ================== mutations ==================
    public function add(Product $p, int $qty = 1): void
    {
        $d = $this->data();
        $items = $d['items'];
        $key = (string)$p->id;

        $items[$key] = [
            'product_id' => $p->id,
            'name'       => $p->name,
            // lưu giá tại thời điểm thêm
            'price'      => (int) $p->price,
            'qty'        => ($items[$key]['qty'] ?? 0) + max(1, $qty),
            'image'      => $p->cover_image ?? $p->image_url ?? null,
        ];

        $d['items'] = $items;
        $this->save($d);
    }

    public function buyNow(Product $p, int $qty = 1): array
    {
        $this->add($p, $qty);
        return $this->all(); // controller sẽ redirect tới trang checkout
    }

    public function updateQty(int $productId, int $qty): void
    {
        $d = $this->data();
        if (isset($d['items'][(string)$productId])) {
            $d['items'][(string)$productId]['qty'] = max(1, $qty);
            $this->save($d);
        }
    }

    public function remove(int $productId): void
    {
        $d = $this->data();
        Arr::forget($d['items'], (string)$productId);
        $this->save($d);
    }

    public function clear(): void
    {
        session()->forget(self::KEY);
        session()->save();
    }

    public function applyCoupon(?string $code): ?Coupon
    {
        $d = $this->data();
        if (!$code) {
            $d['coupon'] = null;
            $this->save($d);
            return null;
        }
        $coupon = Coupon::where('code', strtoupper(trim($code)))->first();
        if (!$coupon || !$coupon->isValid()) return null;

        $d['coupon'] = $coupon->code;
        $this->save($d);
        return $coupon;
    }
}
