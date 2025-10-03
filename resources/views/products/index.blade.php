@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Tất cả sản phẩm</h1>
    <div class="text-muted small">{{ $total ?? $products->total() }} kết quả</div>
  </div>

  {{-- Filter đơn giản theo category --}}
  <form class="row g-2 mb-3" method="GET">
    <div class="col-auto">
      <select class="form-select form-select-sm" name="category" onchange="this.form.submit()">
        <option value="">— Danh mục —</option>
        @foreach(\App\Models\Category::orderBy('name')->get() as $c)
          <option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
  </form>

  <div class="row g-3">
    @forelse($products as $p)
      <div class="col-6 col-md-3">
        @include('components.product-card', ['p' => $p])
      </div>
    @empty
      <p class="text-muted">Chưa có sản phẩm.</p>
    @endforelse
  </div>

  <div class="mt-3">{{ $products->withQueryString()->links() }}</div>
</div>
@endsection
