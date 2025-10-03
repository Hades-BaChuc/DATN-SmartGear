@extends('layouts.app')

@section('content')
<div class="container py-4">

  {{-- Hero banner --}}
  <div class="p-4 p-md-5 mb-4 bg-light rounded-3 border">
    <div class="container-fluid py-2">
      <h1 class="display-6 fw-semibold mb-2">SmartGear – Đồ công nghệ xịn</h1>
      <p class="col-md-8 fs-6 text-muted mb-3">
        Điện thoại, Laptop, Bàn phím, Chuột… giá tốt mỗi ngày. Freeship nội thành cho đơn từ 500k.
      </p>
      <a class="btn btn-primary" href="{{ route('products.index') }}">Mua sắm ngay</a>
    </div>
  </div>

  {{-- Danh mục nổi bật --}}
  <h2 class="h5 mb-3">Danh mục nổi bật</h2>
  <div class="row g-3 mb-4">
    @forelse($categories as $c)
      <div class="col-6 col-md-3">
        <a href="{{ route('products.index') }}?category={{ $c->id }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <div class="fw-semibold">{{ $c->name }}</div>
              <div class="text-muted small mt-1">Xem sản phẩm</div>
            </div>
          </div>
        </a>
      </div>
    @empty
      <p class="text-muted">Chưa có danh mục. Hãy seed dữ liệu categories.</p>
    @endforelse
  </div>

  {{-- Sản phẩm nổi bật --}}
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="h5 mb-0">Sản phẩm nổi bật</h2>
    <a class="small" href="{{ route('products.index') }}">Xem tất cả</a>
  </div>
  <div class="row g-3 mb-5">
    @foreach($featured as $p)
      <div class="col-6 col-md-3">
        @include('components.product-card', ['p' => $p])
      </div>
    @endforeach
  </div>

  {{-- Mỗi danh mục 1 hàng --}}
  @foreach($byCategory as $slug => $list)
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 mb-0">{{ $categories->firstWhere('slug',$slug)?->name }}</h2>
      <a class="small" href="{{ route('products.index') }}?category={{ $categories->firstWhere('slug',$slug)?->id }}">Xem tất cả</a>
    </div>
    <div class="row g-3 mb-4">
      @forelse($list as $p)
        <div class="col-6 col-md-3">
          @include('components.product-card', ['p' => $p])
        </div>
      @empty
        <p class="text-muted">Chưa có sản phẩm.</p>
      @endforelse
    </div>
  @endforeach

</div>
@endsection
