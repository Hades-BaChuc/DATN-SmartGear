<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>@yield('title','SmartGear')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body class="bg-body">

{{-- HEADER: nền trắng, viền cyan, search + giỏ hàng --}}
<header class="border-bottom sticky-top bg-white">
    <div class="container py-2">
        <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('storage/brands/logo/logo.png') }}" alt="Logo" class="logo">
            </a>

            <div class="dropdown category-dropdown">
                <button
                    class="btn btn-primary-soft rounded-3 px-3 dropdown-toggle"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    data-bs-display="static"         {{-- không bị Popper đẩy lệch khi có form/scroll --}}
                    aria-expanded="false">
                    <i class="bi bi-list fs-5 me-1"></i> Danh mục
                </button>

                <div class="dropdown-menu dropdown-menu-categories p-3 shadow">
                    <a class="dropdown-item py-2" href="{{ route('products.index',['category'=>'dien-thoai']) }}">
                        <i class="bi bi-phone me-2"></i> Điện thoại
                    </a>
                    <a class="dropdown-item py-2" href="{{ route('products.index',['category'=>'laptop']) }}">
                        <i class="bi bi-laptop me-2"></i> Laptop
                    </a>
                    <a class="dropdown-item py-2" href="{{ route('products.index',['category'=>'tv']) }}">
                        <i class="bi bi-tv me-2"></i> TV
                    </a>
                    <a class="dropdown-item py-2" href="{{ route('products.index',['category'=>'may-tinh-bang']) }}">
                        <i class="bi bi-tablet-landscape me-2"></i> Máy tính bảng
                    </a>
                    <a class="dropdown-item py-2" href="{{ route('products.index',['category'=>'phu-kien']) }}">
                        <i class="bi bi-earbuds me-2"></i> Phụ kiện
                    </a>

                    <hr class="my-3">
                    <div class="small text-muted mb-2 px-1">Thương hiệu gợi ý</div>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="pill" href="{{ route('products.index',['brand'=>'apple']) }}">Apple</a>
                        <a class="pill" href="{{ route('products.index',['brand'=>'samsung']) }}">Samsung</a>
                        <a class="pill" href="{{ route('products.index',['brand'=>'xiaomi']) }}">Xiaomi</a>
                        <a class="pill" href="{{ route('products.index',['brand'=>'lenovo']) }}">Lenovo</a>
                    </div>
                </div>
            </div>

            <form action="{{ route('products.index') }}" class="flex-grow-1">
                <div class="input-group input-group-lg">
                    <input name="q" class="form-control rounded-start-4" placeholder="Nhập tên điện thoại, laptop, phụ kiện... cần tìm">
                    <button class="btn btn-primary rounded-end-4"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <a href="{{ route('profile.index') }}" class="btn btn-light border"><i class="bi bi-person"></i></a>
            <a href="{{ route('cart.index') }}" class="btn btn-light border position-relative">
                <i class="bi bi-cart3"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge bg-primary text-dark">
            {{ session('cart_count',0) }}
          </span>
            </a>
        </div>
    </div>
</header>

{{-- Danh mục: DROPDOWN (thay cho offcanvas) --}}


<main class="py-4">
    @yield('content')
</main>

<footer class="mt-auto py-5 bg-white border-top">
    <div class="container">
        <div class="row g-3">
            <div class="col-md">
                <h6 class="fw-bold">SmartGear</h6>
                <div class="text-muted small">Bán điện thoại, laptop, phụ kiện, TV và máy tính bảng.</div>
            </div>
            <div class="col-md">
                <h6 class="fw-bold">Chính sách</h6>
                <ul class="list-unstyled small text-muted mb-0">
                    <li>Đổi trả dễ dàng</li>
                    <li>Bảo hành chính hãng</li>
                    <li>Giao hàng nhanh</li>
                </ul>
            </div>
            <div class="col-md">
                <h6 class="fw-bold">Kết nối với chúng tôi</h6>
                <ul class="list-unstyled small text-muted mb-0">
                    <li><a href="#" class="text-decoration-none">Facebook</a></li>
                    <li><a href="#" class="text-decoration-none">Zalo</a></li>
                    <li><a href="#" class="text-decoration-none">Tiktok</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
