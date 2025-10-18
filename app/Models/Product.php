<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    // table 'products' với các cột: id, name, price, old_price, brand, image, tags...
    protected $fillable = ['name','price','old_price','brand','image','tags','slug'];

    protected $casts = [
        'price' => 'integer',
        'old_price' => 'integer',
    ];

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
    public function scopePriceBucket($q, $bucket)
    {
        return match ($bucket) {
            'under-15' => $q->where('price', '<', 15000000),
            '15-20'    => $q->whereBetween('price', [15000000, 20000000]),
            'over-20'  => $q->where('price', '>=', 20000000),
            default    => $q,
        };
    }
    public function images(){ return $this->hasMany(ProductImage::class); }
    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'] ?? $this->attributes['cover_image'] ?? null;
    }
}
