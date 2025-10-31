<?php
// app/Models/ProductImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/ProductImage.php
class ProductImage extends Model {
    protected $fillable = ['product_id','url','is_primary','sort_order'];

    // Ảnh dùng trong view
    protected $appends = ['src'];

    public function product(){ return $this->belongsTo(Product::class); }

    // Nếu 'url' đã là http(s) thì trả nguyên; nếu là đường dẫn tương đối trong disk 'public' thì build URL
    public function getSrcAttribute() {
        $u = $this->attributes['url'] ?? '';
        return preg_match('#^https?://#', $u) ? $u : \Storage::disk('public')->url(ltrim($u, '/'));
    }
}


