@extends('layouts.app')
@section('title','Sản phẩm')

@section('content')
    @php
        // Helper to create link with query parameters intact
        $link = fn(array $qs) => request()->fullUrlWithQuery($qs);
    @endphp

    {{-- FILTERS --}}
    <div class="filters-bar card p-3 mb-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <a href="{{ $link(['q'=>null,'brand'=>null,'category'=>null,'min'=>null,'max'=>null]) }}"
               class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-sliders"></i><span>Bỏ lọc</span>
            </a>
            <div class="vr d-none d-md-block"></div>

            {{-- Price Filter --}}
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">Giá</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ $link(['min'=>null,'max'=>10000000]) }}">Dưới 10 triệu</a></li>
                    <li><a class="dropdown-item" href="{{ $link(['min'=>10000000,'max'=>20000000]) }}">10–20 triệu</a></li>
                    <li><a class="dropdown-item" href="{{ $link(['min'=>20000000,'max'=>null]) }}">Trên 20 triệu</a></li>
                </ul>
            </div>

            {{-- Brand Filter --}}
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">Hãng</button>
                <ul class="dropdown-menu">
                    @foreach(['asus','acer','msi','lenovo','dell','hp'] as $b)
                        <li><a class="dropdown-item" href="{{ $link(['brand'=>$b]) }}">{{ strtoupper($b) }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Category Filter --}}
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">Danh mục</button>
                <ul class="dropdown-menu">
                    @foreach(['laptop','man-hinh','dien-thoai','phu-kien'] as $c)
                        <li><a class="dropdown-item" href="{{ $link(['category'=>$c]) }}">{{ strtoupper($c) }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="ms-auto">
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">Sắp xếp</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ $link(['sort'=>'popular']) }}">Phổ biến</a></li>
                        <li><a class="dropdown-item" href="{{ $link(['sort'=>'price-asc']) }}">Giá tăng dần</a></li>
                        <li><a class="dropdown-item" href="{{ $link(['sort'=>'price-desc']) }}">Giá giảm dần</a></li>
                        <li><a class="dropdown-item" href="{{ $link(['sort'=>'new']) }}">Mới nhất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Product List --}}
    <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
        @forelse($products as $p)
            @php
                // Fallback to price if product details are missing
                $minPrice = $p->details_min_price ?? ($p->price ?? null);
            @endphp
            <div class="col">
                <div class="card prod-card h-100 d-flex flex-column">
                    <div class="position-relative">
                        <img class="card-img-top" src="{{ $p->cover_url }}" alt="{{ $p->product_name }}">
                        <span class="gift-badge" title="Quà tặng"><i class="bi bi-gift"></i></span>
                    </div>

                    <div class="p-3 d-flex flex-column gap-2 flex-grow-1">
                        <a href="{{ route('products.show', $p->slug ?? $p->id) }}"
                           class="stretched-link text-decoration-none fw-semibold">
                            {{ $p->product_name ?? $p->name }}
                        </a>

                        <div class="text-secondary small">
                            {{ $p->brand->name ?? '' }} @if($p->category) • {{ $p->category->name }} @endif
                        </div>

                        <div class="mt-auto">
                            @if($minPrice)
                                <div class="d-flex align-items-baseline gap-2">
                                    <div class="price-new fw-bold">
                                        {{ number_format($minPrice, 0, ',', '.') }}đ
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <button class="btn btn-sm btn-accent w-100">
                                    <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                                </button>
                            </form>

                            <form action="{{ route('cart.buyNow') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <button class="btn btn-sm btn-success w-100">
                                    Mua ngay
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">Không tìm thấy sản phẩm phù hợp.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endsection
