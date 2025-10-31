@extends('layouts.app')
@section('title','Đăng nhập')

@section('content')
    <div class="login-hero">
        <div class="login-box shadow-lg">
            <div class="text-center mb-4">
                <i class="bi bi-bag-check fs-1 text-primary"></i>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small text-muted">Email</label>
                    <input name="email" type="email" class="form-control form-control-lg" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Mật khẩu</label>
                    <input name="password" type="password" class="form-control form-control-lg" required>
                </div>

                <button class="btn btn-primary w-100 btn-lg">Đăng nhập</button>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                    <span class="mx-2">•</span>
                    <a href="{{ route('register') }}">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>
@endsection
