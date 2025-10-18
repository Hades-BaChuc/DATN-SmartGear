@extends('layouts.app')

@section('title', ($currentBrand?->name ? $currentBrand->name.' ' : '').'Laptop')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laptop.index') }}">Laptop</a></li>
                @if($currentBrand)<li class="breadcrumb-item active">{{ $currentBrand->name }}</li>@endif
            </ol>
        </nav>

        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-3 mb-4">
                <div class="card mb-3">
                    <div class="card-header fw-semibold">Hãng sản xuất</div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('laptop.index') }}"
                           class="list-group-item list-group-item-action {{ $currentBrand ? '' : 'active' }}">Tất cả</a>
                        @foreach($brands as $b)
                            <a href="{{ route('laptop.brand', $b->slug) }}"
                               class="list-group-item list-group-item-action {{ $currentBrand?->id === $b->id ? 'active' : '' }}">
                                {{ $b->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header fw-semibold">Mức giá</div>

                    @php $action = $currentBrand ? route('laptop.brand', $currentBrand->slug) : route('laptop.index'); @endphp
                    <form method="get" action="{{ $action }}" id="priceFilterForm">
                        {{-- giữ nguyên sort khi đổi giá --}}
                        @if($sort)<input type="hidden" name="sort" value="{{ $sort }}">@endif

                        <div class="list-group list-group-flush price-filter">

                            {{-- Tất cả --}}
                            <label class="list-group-item d-flex align-items-center gap-2">
                                <input type="checkbox" class="pf-check" name="price" value=""
                                    {{ $bucket===''||$bucket===null ? 'checked' : '' }}>
                                <span>Tất cả</span>
                            </label>

                            {{-- Dưới 15 triệu --}}
                            <label class="list-group-item d-flex align-items-center gap-2">
                                <input type="checkbox" class="pf-check" name="price" value="under-15"
                                    {{ $bucket==='under-15' ? 'checked' : '' }}>
                                <span>Dưới 15 triệu</span>
                            </label>

                            {{-- 15 – 20 triệu --}}
                            <label class="list-group-item d-flex align-items-center gap-2">
                                <input type="checkbox" class="pf-check" name="price" value="15-20"
                                    {{ $bucket==='15-20' ? 'checked' : '' }}>
                                <span>Từ 15 – 20 triệu</span>
                            </label>

                            {{-- Trên 20 triệu --}}
                            <label class="list-group-item d-flex align-items-center gap-2">
                                <input type="checkbox" class="pf-check" name="price" value="over-20"
                                    {{ $bucket==='over-20' ? 'checked' : '' }}>
                                <span>Trên 20 triệu</span>
                            </label>

                        </div>
                    </form>
                </div>
            </div>

            {{-- Main --}}
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        {{ $currentBrand?->name ? $currentBrand->name.' ' : '' }}Laptop
                        <span class="text-muted">({{ $products->total() }} sản phẩm)</span>
                    </h5>

                    <form>
                        {{-- giữ nguyên bộ lọc giá khi đổi sort --}}
                        @if($bucket)<input type="hidden" name="price" value="{{ $bucket }}">@endif
                        <div class="input-group input-group-sm" style="width: 220px">
                            <label class="input-group-text">Sắp xếp</label>
                            <select class="form-select" name="sort" onchange="this.form.submit()">
                                <option value="new" {{ $sort==='new'?'selected':'' }}>Mới nhất</option>
                                <option value="price_asc" {{ $sort==='price_asc'?'selected':'' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ $sort==='price_desc'?'selected':'' }}>Giá giảm dần</option>
                            </select>
                        </div>
                    </form>
                </div>

                @if($products->isEmpty())
                    <div class="alert alert-warning">Không có sản phẩm phù hợp.</div>
                @else
                    <div class="row g-3">
                        @foreach($products as $p)
                            <div class="col-6 col-md-4">
                                <div class="card h-100 product-card">
                                    <a href="{{ route('products.show', $p->id) }}" class="text-decoration-none text-dark">
                                        <div class="product-thumb">
                                            @php
                                                $img = $p->image_url ?: $p->cover_image
                                                    ?: 'https://fptshop.com.vn/Uploads/Originals/2022/8/15/637960855899731067_placeholder.png';
                                            @endphp
                                            <img
                                                src="{{ $img }}"
                                                alt="{{ $p->name }}"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='https://fptshop.com.vn/Uploads/Originals/2022/8/15/637960855899731067_placeholder.png';"
                                            >
                                        </div>
                                        <div class="card-body">
                                            <div class="brand small">{{ $p->brand?->name }}</div>
                                            <div class="fw-semibold mb-1">{{ Str::limit($p->name, 60) }}</div>
                                            <div class="price">{{ number_format($p->price, 0, ',', '.') }}đ</div>
                                            @if($p->short_specs)
                                                <div class="small text-secondary mt-1">{{ Str::limit($p->short_specs, 80) }}</div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="card-footer bg-white border-0">
                                        <form action="{{ route('cart.add') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                                            <button class="btn btn-sm btn-primary w-100">Thêm vào giỏ</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('change', function(e){
            if(e.target.matches('.pf-check')){
                const group = document.querySelectorAll('.pf-check');
                // Bỏ chọn các checkbox khác
                group.forEach(cb => { if (cb !== e.target) cb.checked = false; });
                // Nếu click vào "Tất cả", set value rỗng
                if (e.target.value === '' && e.target.checked) {
                    group.forEach(cb => { if (cb.value !== '') cb.checked = false; });
                }
                // Submit form
                document.getElementById('priceFilterForm').submit();
            }
        });
    </script>
@endpush
