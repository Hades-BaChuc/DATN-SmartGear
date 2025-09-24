<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller {
  public function show(string $slug){
    $book = Book::with(['authors','publisher','categories'])->where('slug',$slug)->firstOrFail();
    $related = Book::where('publisher_id',$book->publisher_id)->whereKeyNot($book->id)->limit(8)->get();
    return view('book-detail', compact('book','related'));
  }
}