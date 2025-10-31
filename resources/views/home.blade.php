@extends('layouts.app')
@section('title','Trang chủ')

@section('content')
    <div class="container">

        {{-- HERO banner --}}
        <div id="carouselHome" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 overflow-hidden shadow-sm">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('storage/banners/home/banner_1.jpeg') }}" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/banners/home/banner_2.jpeg') }}" alt="Banner 2">
                </div>
                <!-- Thêm các banner khác ở đây -->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        {{-- DEAL nổi bật (khung viền bo tròn giống hình) --}}
        <section class="mb-4">
            <div class="deal-frame p-3 p-md-4">
                <div class="row g-3">
                    @foreach(($deals ?? []) as $p)
                        @include('components.product-card', ['p'=>$p])
                    @endforeach
                    {{-- nếu chưa có dữ liệu, render tạm 4 placeholder --}}
                    @for($i=0;$i<4 && empty($deals);$i++)
                        @include('components.product-card', ['p'=>(object)['name'=>'Sản phẩm demo','price'=>24900000,'sale_price'=>21490000,'thumbnail'=>'https://picsum.photos/400/300?random='.$i,'slug'=>'demo-'.$i]])
                    @endfor
                </div>
            </div>
        </section>

        {{-- GỢI Ý THEO NHÓM (điện thoại / laptop / phụ kiện) --}}
        <section class="mb-4">
            <h5 class="fw-bold mb-3">Gợi ý cho bạn</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="sugg-card p-3">
                        <h6 class="mb-3">Điện thoại</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="pill" href="{{ route('products.index',['category'=>'dien-thoai','brand'=>'apple']) }}">Apple</a>
                            <a class="pill" href="{{ route('products.index',['category'=>'dien-thoai','brand'=>'samsung']) }}">Samsung</a>
                            <a class="pill" href="{{ route('products.index',['category'=>'dien-thoai','brand'=>'xiaomi']) }}">Xiaomi</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sugg-card p-3">
                        <h6 class="mb-3">Laptop</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="pill" href="{{ route('products.index',['category'=>'laptop','brand'=>'apple']) }}">MacBook</a>
                            <a class="pill" href="{{ route('products.index',['category'=>'laptop','brand'=>'asus']) }}">ASUS</a>
                            <a class="pill" href="{{ route('products.index',['category'=>'laptop','brand'=>'lenovo']) }}">Lenovo</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sugg-card p-3">
                        <h6 class="mb-3">Phụ kiện</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="pill" href="{{ route('products.index',['category'=>'phu-kien']) }}">Tai nghe</a>
                            <a class="pill" href="{{ route('products.index',['category'=>'phu-kien']) }}">Sạc/cáp</a>
                            <a class="pill" href="{{ route('products.index',['category'=>'phu-kien']) }}">Ốp lưng</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- A) THỊ TRẤN ONLINE, VẠN ƯU ĐÃI (grid banner) --}}
        <section class="mb-4">
            <h4 class="fw-bold mb-3">Thị trấn Online, vạn ưu đãi</h4>
            <div class="row g-3 promo-grid">
                <div class="col-lg-4">
                    <img class="promo-img tall" src="{{ asset('storage/banners/home/promo_1.jpg') }}" alt="Promo 1">
                </div>
                <div class="col-lg-5">
                    <img class="promo-img large" src="{{ asset('storage/banners/home/promo_2.jpg') }}" alt="Promo 2">
                </div>
                <div class="col-lg-3 d-grid gap-3">
                    <img class="promo-img" src="{{ asset('storage/banners/home/promo_3.jpg') }}" alt="Promo 3">
                    <img class="promo-img" src="{{ asset('storage/banners/home/promo_4.jpg') }}" alt="Promo 4">
                    <img class="promo-img" src="{{ asset('storage/banners/home/promo_5.jpg') }}" alt="Promo 5">
                </div>
            </div>
        </section>

    </div>
@endsection
