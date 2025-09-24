@extends('layouts.app')
@section('title', $book['title'] ?? 'Chi tiết sách')
@section('content')
@php($book = $book ?? [
'id'=>1,'title'=>'Dune','author'=>'Frank Herbert','price'=>189000,
'cover'=>'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=800&auto=format&fit=crop',
'description'=>'Mô tả sách demo. Nội dung đang cập nhật…'
])
<nav aria-label="breadcrumb" class="mb-3">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
<li class="breadcrumb-item"><a href="/books">Sách</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $book['title'] }}</li>
</ol>
</nav>


<div class="row g-4">
<div class="col-md-5">
<img class="img-fluid rounded border" src="{{ $book['cover'] }}" alt="{{ $book['title'] }}">
</div>
<div class="col-md-7">
<h1 class="h3">{{ $book['title'] }}</h1>
<div class="text-muted mb-2">{{ $book['author'] }}</div>
<div class="h4 fw-bold mb-3">{{ number_format($book['price'],0,',','.') }} ₫</div>
<p class="text-muted">{{ $book['description'] }}</p>


<form class="vstack gap-3" action="#" method="post">
<div class="input-group w-auto" data-qty-wrap>
<button class="btn btn-outline-secondary" type="button" data-step="dec"><i class="bi bi-dash"></i></button>
<input type="number" class="form-control text-center" style="max-width:80px" name="qty" value="1" min="1">
<button class="btn btn-outline-secondary" type="button" data-step="inc"><i class="bi bi-plus"></i></button>
</div>
<div class="d-flex gap-2">
<button type="button" class="btn btn-dark"><i class="bi bi-cart me-1"></i> Thêm vào giỏ</button>
<a href="/cart" class="btn btn-outline-secondary">Xem giỏ hàng</a>
</div>
</form>
</div>
</div>
@endsection