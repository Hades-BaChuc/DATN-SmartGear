<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\{Product,Category};

class HomeController extends Controller {
  public function index() {
    $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
    $newProducts   = Product::with('publisher')->orderByDesc('id')->limit(12)->get();
    $bestDeals  = Product::orderByDesc('discount_percent')->limit(12)->get();
    $banners = [
      'https://placehold.co/1200x350?text=Banner+1',
      'https://placehold.co/1200x350?text=Banner+2'
    ];
    return view('home', compact('categories','newProducts','bestDeals','banners'));
  }
}