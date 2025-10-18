@extends('layouts.app')
@section('title','Sản phẩm')

@section('content')
@php
// demo data nếu controller chưa truyền $products
$products = $products ?? collect(range(1,8))->map(fn($i)=>[
  'id'=>$i,
  'name'=>"Laptop ASUS Vivobook S14 ($i)",
  'img'=>"/images/prod-$i.jpg",
  'tags'=>['Ultra 7','16GB','512GB','14\" 60Hz'],
  'price'=>20490000 + ($i*100000),
  'old'=>22990000 + ($i*100000),
  'rating'=>4.8,
]);
@endphp

<div class="filters-bar bg-white border rounded-3 p-3 mb-3">
  <div class="d-flex flex-wrap gap-2 align-items-center">
    <button class="btn btn-outline-secondary d-flex align-items-center gap-2">
      <i class="bi bi-sliders"></i><span>Bộ lọc</span>
    </button>

    <div class="vr d-none d-md-block"></div>

    <div class="dropdown">
      <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">Tình trạng</button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="?status=all">Tất cả</a></li>
        <li><a class="dropdown-item" href="?status=in-stock">Còn hàng</a></li>
      </ul>
    </div>

    <div class="dropdown">
      <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">Giá</button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="?price=lt-10">Dưới 10 triệu</a></li>
        <li><a class="dropdown-item" href="?price=10-20">10–20 triệu</a></li>
        <li><a class="dropdown-item" href="?price=gt-20">Trên 20 triệu</a></li>
      </ul>
    </div>

    <div class="dropdown">
      <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">Hãng</button>
      <ul class="dropdown-menu">
        @foreach(['ASUS','ACER','MSI','LENOVO','DELL','HP'] as $b)
        <li><a class="dropdown-item" href="?brand={{ strtolower($b) }}">{{ $b }}</a></li>
        @endforeach
      </ul>
    </div>

    <div class="ms-auto">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">Sắp xếp</button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="?sort=popular">Phổ biến</a></li>
          <li><a class="dropdown-item" href="?sort=price-asc">Giá tăng dần</a></li>
          <li><a class="dropdown-item" href="?sort=price-desc">Giá giảm dần</a></li>
          <li><a class="dropdown-item" href="?sort=new">Mới nhất</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
  @foreach($products as $p)
  <div class="col">
    <div class="prod-card h-100 d-flex flex-column">
      <div class="position-relative">
        <img class="w-100 ratio-4x3 rounded-top" src="{{ $p['img'] }}" alt="{{ $p['name'] }}">
        <span class="gift-badge" title="Quà tặng"><i class="bi bi-gift"></i></span>
      </div>
      <div class="p-3 d-flex flex-column gap-2 flex-grow-1">
        <a href="/products/{{ $p['id'] }}" class="stretched-link text-decoration-none text-dark fw-semibold">
          {{ $p['name'] }}
        </a>
        <div class="d-flex flex-wrap gap-2">
          @foreach($p['tags'] as $t)
          <span class="spec-chip"><i class="bi bi-dot"></i>{{ $t }}</span>
          @endforeach
        </div>

        <div class="mt-auto">
          <div class="d-flex align-items-baseline gap-2">
            <div class="price-new text-danger fw-bold">{{ number_format($p['price'],0,',','.') }}đ</div>
            <div class="price-old text-muted text-decoration-line-through small">{{ number_format($p['old'],0,',','.') }}đ</div>
            <span class="discount-badge">-{{ round((1 - $p['price']/$p['old'])*100) }}%</span>
          </div>
          <div class="small text-warning mt-1">
            <i class="bi bi-star-fill"></i> {{ $p['rating'] }} <span class="text-muted">(đánh giá)</span>
          </div>
          <form action="{{ route('cart.add') }}" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ $p->id }}">
              <button class="btn btn-sm btn-dark w-100"><i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
