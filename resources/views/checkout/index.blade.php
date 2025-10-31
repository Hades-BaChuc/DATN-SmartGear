@extends('layouts.shop')
@section('name','Thanh toán')
@section('content')
    <!-- checkout/index.blade.php -->
    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf
        <!-- Guest user fields (if not logged in) -->
        <div>
            <label for="full_name">Họ và tên</label>
            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $fullName) }}" required>
        </div>

        <div>
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $phone) }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $email) }}">
        </div>

        <div>
            <label for="address_text">Địa chỉ</label>
            <textarea name="address_text" id="address_text" required>{{ old('address_text', $addressText) }}</textarea>
        </div>

        <button type="submit">Đặt hàng</button>
    </form>

@endsection
