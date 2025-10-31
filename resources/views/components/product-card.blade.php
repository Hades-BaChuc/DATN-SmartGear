@php($href = isset($p->slug) ? route('products.show',$p->slug) : '#')
<div class="col-6 col-md-4 col-lg-3">
    <a href="{{ $href }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm border-0 product-card">
            <img src="{{ $p->thumbnail ?? 'https://picsum.photos/400/300' }}" class="card-img-top" alt="{{ $p->name ?? 'Sản phẩm' }}">
            <div class="card-body">
                <h6 class="card-title text-truncate mb-1">{{ $p->name ?? 'Sản phẩm' }}</h6>
                <div class="d-flex align-items-baseline gap-2">
                    <div class="price">{{ number_format(($p->sale_price ?? $p->price ?? 0),0,'.','.') }} ₫</div>
                    @if(($p->sale_price ?? 0) && ($p->price ?? 0) > ($p->sale_price ?? 0))
                        <small class="text-muted text-decoration-line-through">{{ number_format($p->price,0,'.','.') }} ₫</small>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>
