@extends('layouts.app')
@section('name','Trang chủ')
@section('content')
<!-- Hero -->
<div class="p-5 p-md-5 mb-4 bg-white border rounded-3">
<div class="row align-items-center g-4">
<div class="col-md-7">
<h1 class="display-6 fw-bold">Khám phá thế giới qua từng trang sách</h1>
<p class="lead text-muted">Ưu đãi đến 30% cho sách mới ra mắt. Miễn phí giao hàng đơn từ 300.000₫.</p>
<a href="/products" class="btn btn-dark btn-lg">Mua ngay <i class="bi bi-chevron-right"></i></a>
</div>
<div class="col-md-5">
<img class="img-fluid rounded" alt="products" src="https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1200&auto=format&fit=crop">
</div>
</div>
</div>

<!-- Bestsellers -->
<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="h4 fw-bold mb-0">Bán chạy</h2>
<a href="/products" class="btn btn-outline-secondary btn-sm">Xem tất cả</a>
</div>
<div class="row g-3">
@php($products = $bestsellers ?? [
['name'=>'Dune','author'=>'Frank Herbert','price'=>189000,'cover'=>'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop'],
['name'=>'Atomic Habits','author'=>'James Clear','price'=>159000,'cover'=>'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=600&auto=format&fit=crop'],
['name'=>'Sapiens','author'=>'Yuval Noah Harari','price'=>210000,'cover'=>'https://images.unsplash.com/photo-1519682337058-a94d519337bc?q=80&w=600&auto=format&fit=crop'],
['name'=>'Clean Code','author'=>'Robert C. Martin','price'=>259000,'cover'=>'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?q=80&w=600&auto=format&fit=crop'],
])
@foreach($products as $b)
<div class="col-6 col-md-3">
<div class="card h-100">
<img class="card-img-top book-cover" src="{{ $b['cover'] }}" alt="{{ $b['name'] }}">
<div class="card-body d-flex flex-column">
<h3 class="h6 line-clamp-2 mb-1">{{ $b['name'] }}</h3>
<div class="text-muted small mb-2">{{ $b['author'] }}</div>
<div class="mt-auto fw-semibold">{{ number_format($b['price'],0,',','.') }} ₫</div>
<a href="/products/1" class="btn btn-dark btn-sm mt-2"><i class="bi bi-cart me-1"></i> Thêm vào giỏ</a>
</div>
</div>
</div>
@endforeach
</div>
@endsection