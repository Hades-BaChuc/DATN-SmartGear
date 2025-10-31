<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;   // <-- đúng
// use App\Models\HasMany;  <-- XÓA dòng sai này
use App\Models\Product;

class Brand extends Model
{
    protected $fillable = ['name', 'slug', 'logo_url'];

    public function products(): HasMany
    {
        // Giữ 1 return duy nhất
        return $this->hasMany(Product::class, 'brand_id');
    }
}
