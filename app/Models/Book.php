<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {
  use HasFactory;
  protected $fillable = ['title','slug','isbn','price','discount_percent','stock','format','language','pages','weight','size','publish_year','publisher_id','description','cover_image','status'];
  public function categories(){ return $this->belongsToMany(Category::class, 'book_category'); }
  public function authors(){ return $this->belongsToMany(Author::class, 'book_author'); }
  public function publisher(){ return $this->belongsTo(Publisher::class); }
  public function getFinalPriceAttribute(){ return (int) round($this->price * (100 - $this->discount_percent) / 100); }
}