<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\{Product,Category};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller {
  public function show(Request $r, string $slug){
    $category = Category::where('slug',$slug)->firstOrFail();
    $q = Product::query()->whereHas('categories', fn(Builder $b)=>$b->where('categories.id',$category->id));
    if($s = $r->query('q')) $q->where('name','like',"%$s%");
    $products = $q->with('publisher')->orderByDesc('id')->paginate(24)->withQueryString();
    return view('category', compact('category','products'));
  }
}