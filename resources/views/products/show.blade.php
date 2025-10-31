@extends('layouts.app')
@section('title', $product->name)

@section('content')
    <div class="container product-page">
        {{-- Breadcrumb --}}
        <nav class="small mb-3">
            <a href="{{ route('home') }}">Trang chủ</a> /
            <a href="{{ route('products.index', ['category'=>$product->category->slug ?? null]) }}">
                {{ $product->category->name ?? 'Danh mục' }}
            </a> /
            <span class="text-muted">{{ $product->name }}</span>
        </nav>

        <div class="row g-4">
            {{-- Gallery trái --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-3">
                    @php $primary = optional($product->images->first())->src; @endphp
                    <img id="mainImg" class="w-100 rounded-3 mb-3 product-main"
                         src="{{ $primary ?? 'https://picsum.photos/900/600' }}" alt="{{ $product->name }}">
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($product->images as $img)
                            <img class="thumb" width="80" height="80"
                                 src="{{ $img->src }}" data-src="{{ $img->src }}" alt="{{ $product->name }}">
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Thông tin + mua phải --}}
            <div class="col-lg-6">
                <h3 class="fw-bold mb-2">{{ $product->name }}</h3>
                <div class="text-muted mb-3">Mã: {{ $product->sku ?? ('SP'.$product->id) }}</div>

                <div class="card border-0 shadow-sm p-3 price-card mb-3">
                    <div class="d-flex align-items-baseline gap-3">
                        <div class="h3 m-0 fw-bold text-danger">
                            {{ number_format($product->sale_price ?? $product->price,0,'.','.') }} ₫
                        </div>
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="text-muted text-decoration-line-through">
                                {{ number_format($product->price,0,'.','.') }} ₫
                            </div>
                            <span class="badge bg-warning text-dark">
              -{{ round(100 - ($product->sale_price/$product->price)*100) }}%
            </span>
                        @endif
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button class="btn btn-sm btn-accent w-100">
                                <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                            </button>
                        </form>

                        <form action="{{ route('cart.buyNow') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button class="btn btn-sm btn-success w-100">
                                Mua ngay
                            </button>
                        </form>

                    </div>
                </div>

                {{-- Chính sách ngắn --}}
                <div class="row g-2 small text-muted">
                    <div class="col-6"><i class="bi bi-shield-check me-1"></i>Hàng chính hãng</div>
                    <div class="col-6"><i class="bi bi-truck me-1"></i>Giao nhanh toàn quốc</div>
                    <div class="col-6"><i class="bi bi-tools me-1"></i>Cài đặt miễn phí</div>
                    <div class="col-6"><i class="bi bi-headset me-1"></i>Kỹ thuật viên hỗ trợ</div>
                </div>
            </div>
        </div>

        {{-- Thông số nổi bật (demo nếu chưa có spec) --}}
        <div class="card border-0 shadow-sm p-4 mt-4">
            <h5 class="fw-bold mb-3">Thông số nổi bật</h5>
            <div class="row row-cols-2 row-cols-md-4 g-3">
                <div><div class="spec">CPU</div><div class="specv">{{ $product->cpu ?? '—' }}</div></div>
                <div><div class="spec">RAM</div><div class="specv">{{ $product->ram ?? '—' }}</div></div>
                <div><div class="spec">Lưu trữ</div><div class="specv">{{ $product->storage ?? '—' }}</div></div>
                <div><div class="spec">Màn hình</div><div class="specv">{{ $product->display ?? '—' }}</div></div>
            </div>
        </div>

        {{-- Mô tả sản phẩm --}}
        <div class="card border-0 shadow-sm p-4 mt-4">
            <h5 class="fw-bold mb-3">Mô tả sản phẩm</h5>
            <div class="product-desc">
                {!! nl2br(e($product->description ?? 'Đang cập nhật...')) !!}
            </div>
        </div>

        {{-- Đánh giá (skeleton) --}}
        <div class="card border-0 shadow-sm p-4 mt-4">
            <h5 class="fw-bold mb-3">Đánh giá & bình luận</h5>
            @forelse($reviews as $rv)
                <div class="mb-3">
                    <div class="fw-semibold">{{ $rv->user->name ?? 'Khách' }}</div>
                    <div class="small text-muted">{{ $rv->created_at?->diffForHumans() }}</div>
                    <div>{{ $rv->content }}</div>
                </div>
                <hr>
            @empty
                <div class="text-muted">Chưa có đánh giá.</div>
            @endforelse
        </div>

        {{-- Gợi ý dành cho bạn (scroll hàng ngang) --}}
        <section class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="fw-bold mb-0">Gợi ý dành cho bạn</h4>
                <div class="d-none d-md-flex gap-2">
                    <button class="scroll-btn btn btn-light border" data-target="#relRow" data-dir="-1"><i class="bi bi-chevron-left"></i></button>
                    <button class="scroll-btn btn btn-light border" data-target="#relRow" data-dir="1"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            <div id="relRow" class="scroll-row">
                @forelse($related as $p)
                    <div class="scroll-item">
                        @include('components.product-card',['p'=>$p])
                    </div>
                @empty
                    @for($i=0;$i<6;$i++)
                        <div class="scroll-item">
                            @include('components.product-card',['p'=>(object)['name'=>"Sản phẩm demo",'price'=>7990000,'sale_price'=>6990000,'thumbnail'=>"https://picsum.photos/400/300?seed=$i",'slug'=>"demo-$i"]])
                        </div>
                    @endfor
                @endforelse
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // đổi ảnh chính khi click thumbnail
        document.querySelectorAll('.thumb').forEach(img=>{
            img.addEventListener('click', ()=>{
                const main = document.getElementById('mainImg');
                main.src = img.dataset.src || img.src;
            });
        });
    </script>
@endpush
