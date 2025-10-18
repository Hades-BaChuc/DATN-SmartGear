@extends('layouts.app')
@section('title','Đăng ký')

@push('styles')
    <style>
        .auth-wrap{min-height:70vh;display:grid;place-items:center}
        .auth-card{background:var(--bg-700);border:1px solid var(--card-border);border-radius:18px;max-width:520px;width:100%}
        .auth-card .title{font-weight:700;letter-spacing:.5px}
        .auth-card .form-control{background:#0f1722;border:1px solid var(--card-border);color:#e5e7eb;border-radius:12px}
        .auth-card .btn-primary{border-radius:12px}
        .auth-links a{color:#93c5fd;text-decoration:none}
        .auth-links a:hover{text-decoration:underline}
    </style>
@endpush

@section('content')
    <div class="auth-wrap">
        <div class="auth-card p-4 p-md-5 shadow-sm">
            <h4 class="title mb-3">Tạo tài khoản</h4>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    @foreach ($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{ route('register.post') }}" class="vstack gap-3">
                @csrf
                <div>
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                    </div>
                </div>

                <button class="btn btn-primary w-100 py-2">Đăng ký</button>
            </form>

            <div class="auth-links mt-3 text-center">
                Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
            </div>
        </div>
    </div>
@endsection
