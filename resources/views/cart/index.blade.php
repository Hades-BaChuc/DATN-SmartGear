@extends('layouts.app')
@section('name','Giỏ hàng')
@section('content')
@php($items = $items ?? [
['id'=>1,'name'=>'Dune','author'=>'Frank Herbert','price'=>189000,'qty'=>1,'cover'=>'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=400&auto=format&fit=crop'],
['id'=>2,'name'=>'Atomic Habits','author'=>'James Clear','price'=>159000,'qty'=>2,'cover'=>'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=400&auto=format&fit=crop'],
])
@php($subtotal = collect($items)->sum(fn($i)=>$i['price']*$i['qty']))


<div class="row g-4">
<section class="col-lg-8">
<div class="bg-white border rounded-3 p-3">
<h1 class="h5 mb-3">Sản phẩm</h1>
<div class="table-responsive">
<table class="table align-middle">
<thead><tr><th>Sản phẩm</th><th class="text-center">Số lượng</th><th class="text-end">Đơn giá</th><th class="text-end">Thành tiền</th><th></th></tr></thead>
<tbody>
@foreach($items as $it)
<tr>
<td>
<div class="d-flex align-items-center gap-3">
<img class="rounded border" width="48" height="64" src="{{ $it['cover'] }}" alt="{{ $it['name'] }}">
<div>
<div class="fw-semibold">{{ $it['name'] }}</div>
<div class="text-muted small">{{ $it['author'] }}</div>
</div>
</div>
</td>
<td class="text-center" style="max-width: 140px">
<div class="input-group input-group-sm mx-auto" data-qty-wrap>
<button class="btn btn-outline-secondary" type="button" data-step="dec"><i class="bi bi-dash"></i></button>
<input type="number" class="form-control text-center" value="{{ $it['qty'] }}" min="1">
<button class="btn btn-outline-secondary" type="button" data-step="inc"><i class="bi bi-plus"></i></button>
</div>
</td>
<td class="text-end">{{ number_format($it['price'],0,',','.') }} ₫</td>
<td class="text-end">{{ number_format($it['price']*$it['qty'],0,',','.') }} ₫</td>
<td class="text-end"><button class="btn btn-link text-danger p-0"><i class="bi bi-x-lg"></i></button></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</section>


<aside class="col-lg-4">
<div class="bg-white border rounded-3 p-3">
<h2 class="h6">Tóm tắt đơn</h2>
<div class="d-flex justify-content-between"><span>Tạm tính</span><span>{{ number_format($subtotal,0,',','.') }} ₫</span></div>
<div class="d-flex justify-content-between"><span>Vận chuyển</span><span>—</span></div>
<hr>
<div class="d-flex justify-content-between fw-bold"><span>Thành tiền</span><span>{{ number_format($subtotal,0,',','.') }} ₫</span></div>
<a href="/checkout" class="btn btn-dark w-100 mt-3">Thanh toán</a>
</div>
</aside>
</div>
@endsection