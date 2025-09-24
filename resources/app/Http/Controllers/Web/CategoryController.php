<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\{Book,Category};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller {
  public function show(Request $r, string $slug){
    $category = Category::where('slug',$slug)->firstOrFail();
    $q = Book::query()->whereHas('categories', fn(Builder $b)=>$b->where('categories.id',$category->id));
    if($s = $r->query('q')) $q->where('title','like',"%$s%");
    $books = $q->with('publisher')->orderByDesc('id')->paginate(24)->withQueryString();
    return view('category', compact('category','books'));
  }
}