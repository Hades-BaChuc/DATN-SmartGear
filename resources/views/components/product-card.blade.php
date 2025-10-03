<div class="card h-100 shadow-sm">
  <a href="{{ route('products.show', $p->id) }}" class="text-decoration-none text-dark">
    <img class="card-img-top" src="{{ $p->cover_image ?? 'https://picsum.photos/600/400?random='.$p->id }}" alt="{{ $p->name }}">
    <div class="card-body">
      <div class="small text-muted mb-1">{{ $p->brand->name ?? '—' }}</div>
      <h3 class="h6 card-title">{{ Str::limit($p->name, 60) }}</h3>
      <div class="fw-semibold text-danger">
        {{ number_format($p->price,0,',','.') }}₫
        @if($p->discount_percent)
          <small class="text-muted">-{{ $p->discount_percent }}%</small>
        @endif
      </div>
    </div>
  </a>
  <div class="card-footer bg-white border-0">
    <form method="POST" action="{{ route('cart.add') }}">
      @csrf
      <input type="hidden" name="product_id" value="{{ $p->id }}">
      <button class="btn btn-sm btn-primary w-100">Thêm vào giỏ</button>
    </form>
  </div>
</div>
