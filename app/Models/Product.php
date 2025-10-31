<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // Khai báo fillable (tuỳ theo cột bạn có)
    protected $fillable = [
        'category_id', 'brand_id', 'product_name', 'slug',
        'is_hidden', 'is_hot', 'view', 'description', 'image_url'
    ];

    // ---- Quan hệ chính
    public function images() {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    // ---- Scopes lọc theo tham số trên URL
    public function scopeVisible($q)
    {
        return $q->where('is_hidden', false);
    }

    public function scopeFilterBrand($q, ?string $brand)
    {
        if (!$brand) return $q;
        return $q->whereHas('brand', function ($qq) use ($brand) {
            $qq->where('slug', $brand)->orWhere('name', $brand);
        });
    }

    public function scopeFilterCategory($q, ?string $cat)
    {
        if (!$cat) return $q;
        return $q->whereHas('category', function ($qq) use ($cat) {
            $qq->where('slug', $cat)->orWhere('name', $cat);
        });
    }

    public function scopeFilterPrice($q, $min = null, $max = null)
    {
        // giá nằm ở product_detail → lọc qua whereHas
        return $q->when(is_numeric($min) || is_numeric($max), function ($qq) use ($min, $max) {
            $qq->whereHas('details', function ($qd) use ($min, $max) {
                if (is_numeric($min)) $qd->where('price', '>=', $min);
                if (is_numeric($max)) $qd->where('price', '<=', $max);
            });
        });
    }

    // ---- Sắp xếp (giá lấy theo min price của details)
    public function scopeSortBy($q, string $sort)
    {
        // withMin sinh cột ảo details_min_price để orderBy
        $q->withMin('details', 'price');

        return match ($sort) {
            'price-asc'  => $q->orderBy('details_min_price'),
            'price-desc' => $q->orderByDesc('details_min_price'),
            'popular'    => $q->orderByDesc('view'),
            default      => $q->latest('id'), // new
        };
    }

    // ---- Ảnh bìa (giữ nguyên logic tốt của bạn)
    public function getCoverUrlAttribute(): string {
        // Ưu tiên cột image_url nếu tồn tại file; sau đó lấy ảnh đầu tiên trong images
        $exists = fn ($rel) => $rel && \Storage::disk('public')->exists(ltrim($rel,'/'));
        $toUrl  = fn ($rel) => \Storage::disk('public')->url(ltrim($rel,'/'));

        if ($this->image_url && $exists($this->image_url)) return $toUrl($this->image_url);
        $img = $this->images->first();
        if ($img) return $img->src;
        return asset('images/placeholder.png');
    }

    public function getCoverImageAttribute(): string
    {
        return $this->cover_url;
    }

    // (tuỳ chọn) reviews như cũ
    public function reviews(){ return $this->hasMany(Review::class); }

    public function refreshRating(): void {
        $agg = $this->reviews()->selectRaw('COUNT(*) c, AVG(rating) a')->first();
        $this->rating_count = (int)($agg->c ?? 0);
        $this->rating_avg   = round($agg->a ?? 0, 2);
        $this->save();
    }

    // Lấy ảnh thumbnail
    public function getThumbnailUrlAttribute() {
        $img = $this->images->firstWhere('is_primary', 1) ?? $this->images->first();
        return $img?->url ?? asset('images/placeholder.png'); // static placeholder
    }
}
