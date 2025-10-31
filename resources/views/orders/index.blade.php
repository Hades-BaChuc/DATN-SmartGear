@extends('layouts.shop')
@section('title','Giỏ hàng')

@section('content')
    @php
        // demo items nếu controller chưa truyền $items
        $items = $items ?? [
          ['id'=>1,'name'=>'ASUS Vivobook S14','img'=>'/images/prod-1.jpg','price'=>20490000,'qty'=>1,'attrs'=>'Ultra 7 • 16GB • 512GB'],
          ['id'=>2,'name'=>'ASUS ExpertBook B1','img'=>'/images/prod-2.jpg','price'=>12190000,'qty'=>2,'attrs'=>'Ryzen 5 • 16GB • 512GB'],
        ];
        $subtotal = collect($items)->sum(fn($i)=>$i['price']*$i['qty']);
    @endphp

    <div class="container cart-page">
        {{-- Steps --}}
        <div class="cart-steps">
            <div class="step is-active">Giỏ hàng</div>
            <div class="step">Thông tin đặt hàng</div>
            <div class="step">Thanh toán</div>
            <div class="step">Hoàn tất</div>
        </div>

        @if(empty($items))
            {{-- EMPTY --}}
            <div class="cart-card cart-empty">
                <div class="icon"><i class="bi bi-bag-dash"></i></div>
                <div class="h5 fw-semibold mb-2">Giỏ hàng của bạn đang trống</div>
                <a href="{{ route('laptop.index') }}" class="btn btn-primary px-4">Tiếp tục mua sắm</a>
            </div>
        @else
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="cart-card">
                        @foreach($items as $i)
                            <div class="d-flex gap-3 align-items-center py-3 border-bottom border-0"
                                 data-id="{{ $i['id'] }}" data-price="{{ $i['price'] }}">
                                {{-- thumb --}}
                                <div style="width:88px;height:66px;border-radius:10px;background:#0f1a2b;display:grid;place-items:center;overflow:hidden">
                                    <img src="{{ $i['img'] }}" alt="{{ $i['name'] }}" style="width:100%;height:100%;object-fit:contain">
                                </div>

                                {{-- info --}}
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $i['name'] }}</div>
                                    <div class="text-muted small">{{ $i['attrs'] }}</div>
                                    <div class="price mt-1 item-price">{{ number_format($i['price'],0,',','.') }}đ</div>
                                </div>

                                {{-- qty --}}
                                <div class="qty-stepper" data-qty-wrap>
                                    <button type="button" class="btn-dec" data-step="dec">−</button>
                                    <input type="number" min="1" max="99" value="{{ $i['qty'] }}">
                                    <button type="button" class="btn-inc" data-step="inc">+</button>
                                </div>

                                {{-- line total + remove --}}
                                <div class="text-end" style="width:140px">
                                    <div class="fw-semibold subtotal line-total">
                                        {{ number_format($i['price']*$i['qty'],0,',','.') }}đ
                                    </div>
                                    <button class="btn btn-link text-danger p-0 mt-1" data-remove>
                                        <i class="bi bi-x-circle"></i> Xoá
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-muted small pt-3">* Giá đã bao gồm VAT nếu có.</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="cart-summary position-sticky" style="top:80px">
                        <h6 class="mb-3">Tóm tắt đơn hàng</h6>

                        <div class="row-line">
                            <span>Tạm tính</span>
                            <span id="subtotal">{{ number_format($subtotal,0,',','.') }}đ</span>
                        </div>
                        <div class="row-line">
                            <span>Giảm giá</span>
                            <span id="discount" class="text-success">-0đ</span>
                        </div>
                        <div class="row-line">
                            <span>Phí vận chuyển</span>
                            <span id="shipping">Miễn phí</span>
                        </div>

                        <hr>

                        <div class="row-line total">
                            <span>Tổng</span>
                            <span id="grand">{{ number_format($subtotal,0,',','.') }}đ</span>
                        </div>

                        <div class="input-group mt-3">
                            <input type="text" class="form-control" placeholder="Nhập mã giảm giá" id="coupon">
                            <button class="btn btn-outline-light" type="button" id="apply-coupon">Áp dụng</button>
                        </div>

                        <a href="/checkout" class="btn btn-primary w-100 mt-3 py-2">Tiến hành đặt hàng</a>
                        <a href="{{ route('laptop.index') }}" class="btn btn-link w-100 mt-2">Tiếp tục mua sắm</a>
                    </aside>
                </div>
            </div>
        @endif
    </div>
@endsection
