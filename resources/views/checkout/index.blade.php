@extends('layouts.app')
@section('title','Thanh toán')
@section('content')
<div class="row g-4">
<section class="col-lg-8">
<div class="bg-white border rounded-3 p-3">
<h1 class="h5">Thông tin giao hàng</h1>
<div class="row g-3 mt-1">
<div class="col-md-6"><input class="form-control" placeholder="Họ tên"></div>
<div class="col-md-6"><input class="form-control" placeholder="Số điện thoại"></div>
<div class="col-12"><input class="form-control" placeholder="Địa chỉ"></div>
<div class="col-md-4"><input class="form-control" placeholder="Tỉnh/Thành"></div>
<div class="col-md-4"><input class="form-control" placeholder="Quận/Huyện"></div>
<div class="col-md-4"><input class="form-control" placeholder="Phường/Xã"></div>
</div>


<h2 class="h6 mt-4">Phương thức thanh toán</h2>
<div class="vstack gap-2">
<label class="form-check">
<input class="form-check-input" type="radio" name="pm" checked>
<span class="form-check-label">COD (Thanh toán khi nhận hàng)</span>
</label>
<label class="form-check">
<input class="form-check-input" type="radio" name="pm">
<span class="form-check-label">VNPay</span>
</label>
<label class="form-check">
<input class="form-check-input" type="radio" name="pm">
<span class="form-check-label">Momo</span>
</label>
</div>


<div class="mt-4 d-flex gap-2">
<a href="/cart" class="btn btn-outline-secondary">Quay lại giỏ hàng</a>
<button class="btn btn-dark">Đặt hàng</button>
</div>
</div>
</section>


<aside class="col-lg-4">
@php($total = $total ?? 348000)
<div class="bg-white border rounded-3 p-3">
<h2 class="h6">Đơn hàng</h2>
<div class="d-flex justify-content-between"><span>Tổng</span><span class="fw-bold">{{ number_format($total,0,',','.') }} ₫</span></div>
<p class="text-muted small mt-2 mb-0">(Phí vận chuyển sẽ được tính ở bước sau)</p>
</div>
</aside>
</div>
@endsection