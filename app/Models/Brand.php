<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Brand extends Model
{
  use HasFactory;
  protected $fillable = ['name','slug','bio'];
  public function products(){ return $this->belongsToMany(Product::class,'book_author'); }
}