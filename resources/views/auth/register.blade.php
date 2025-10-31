@extends('layouts.app')
@section('title','Đăng ký')

@section('content')
    <div class="container" style="max-width: 760px;">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4">Tạo tài khoản</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ tên</label>
                            <input name="name" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input name="phone" class="form-control form-control-lg">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Địa chỉ</label>
                            <input name="address" class="form-control form-control-lg" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu</label>
                            <input name="password" type="password" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nhập lại mật khẩu</label>
                            <input name="password_confirmation" type="password" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-lg mt-4">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
@endsection
