@extends('layouts.app')
@section('title','Giỏ hàng')

@section('content')
    <div class="container">
        <h2>Giỏ hàng của bạn</h2>
        <div class="cart-list">
            @if(count($cart) > 0)
                @foreach($cart as $id => $item)
                    <div class="cart-item">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 100px;">
                        <div class="cart-item-info">
                            <div class="cart-item-title">{{ $item['name'] }}</div>
                            <div class="cart-item-price">{{ number_format($item['price'], 0, ',', '.') }} đ</div>
                        </div>
                        <form action="{{ route('cart.updateQuantity', $id) }}" method="POST" class="cart-item-quantity">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="btn btn-sm btn-outline-secondary">-</button>
                            <span>{{ $item['quantity'] }}</span>
                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="btn btn-sm btn-outline-secondary">+</button>
                        </form>
                        <div class="cart-item-price">
                            Tổng: {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                        </div>
                    </div>
                @endforeach
                <div class="cart-summary">
                    <div class="cart-summary-total">
                        <div>Tổng tiền:</div>
                        <div>{{ number_format($total, 0, ',', '.') }} đ</div>
                    </div>
                    <form action="{{ route('checkout.index') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary">Thanh toán</button>
                    </form>
                </div>
            @else
                <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
            @endif
        </div>
    </div>
@endsection
