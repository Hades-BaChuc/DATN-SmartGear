@extends('layouts.app')

@section('name', $product->name)
@section('content')
<div class="container py-4">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
  </nav>

  <div class="row g-4">
    <div class="col-md-5">
      <img class="img-fluid rounded border book-cover"
           src="{{ $product->cover_image ?? 'https://picsum.photos/600/800?random='.$product->id }}"
           alt="{{ $product->name }}">
    </div>
    <div class="col-md-7">
      <h1 class="h3">{{ $product->name }}</h1>
      <div class="text-muted mb-2">
        Thương hiệu: {{ optional($product->brand)->name ?? '—' }} ·
        Danh mục: {{ optional($product->category)->name ?? '—' }}
      </div>

      <div class="fs-4 fw-semibold text-danger mb-3">
        {{ number_format($product->price, 0, ',', '.') }}₫
        @if($product->discount_percent) <small class="text-muted">(-{{ $product->discount_percent }}%)</small> @endif
      </div>

      <p class="mb-3">{{ $product->description }}</p>

      <ul class="list-unstyled small text-muted mb-4">
        <li>Mã: {{ $product->sku ?? '—' }}</li>
        <li>Mẫu: {{ $product->model ?? '—' }}</li>
        <li>Năm: {{ $product->release_year ?? '—' }}</li>
        <li>Bảo hành: {{ $product->warranty_months ? $product->warranty_months.' tháng' : '—' }}</li>
      </ul>

      <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ</button>
    </div>
  </div>
</div>
@endsection
