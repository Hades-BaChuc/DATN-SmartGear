{{-- Top bar giống hình GEARVN --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-gearvn sticky-top py-2">
  <div class="container-xl align-items-center gap-3">

    {{-- Logo / Brand (có thể thay bằng <img> nếu bạn có file logo) --}}
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
      {{-- <img src="/logo.svg" alt="Productshop" height="28"> --}}
      Productshop
    </a>

{{-- Danh mục + Mega dropdown (5 mục) --}}
<div class="dropdown position-static d-none d-lg-block">
  <button class="btn btn-menu dropdown-toggle d-inline-flex align-items-center gap-2"
          data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
    <i class="bi bi-list fs-5"></i>
    <span class="fw-semibold">Danh mục</span>
  </button>

  <div class="dropdown-menu dropdown-mega p-0 mt-2">
    <div class="container-xl">
      <div class="mega-wrap">
        {{-- LEFT: danh mục --}}
        <ul class="mega-left list-unstyled m-0">
          <li class="mega-item active" data-target="#panel-laptop">
              <i class="bi bi-laptop"></i>
                <a href="{{ route('laptop.index') }}" class="text-reset text-decoration-none">Laptop</a>
              <i class="bi bi-chevron-right ms-auto"></i>
          </li>
          <li class="mega-item" data-target="#panel-monitor">
            <i class="bi bi-display"></i><span>Màn hình</span><i class="bi bi-chevron-right ms-auto"></i>
          </li>
          <li class="mega-item" data-target="#panel-phone">
            <i class="bi bi-phone"></i><span>Điện thoại</span><i class="bi bi-chevron-right ms-auto"></i>
          </li>
          <li class="mega-item" data-target="#panel-mouse">
            <i class="bi bi-mouse"></i><span>Chuột + Lót chuột</span><i class="bi bi-chevron-right ms-auto"></i>
          </li>
          <li class="mega-item" data-target="#panel-headset">
            <i class="bi bi-headphones"></i><span>Tai nghe</span><i class="bi bi-chevron-right ms-auto"></i>
          </li>
        </ul>

        {{-- RIGHT: panel nội dung --}}
        <div class="mega-right">
          {{-- Laptop --}}
          <div class="mega-panel show" id="panel-laptop">
            <div class="row g-4">
              <div class="col-md-3">
                <div class="mega-heading">Thương hiệu</div>
                <ul class="mega-links">
                    <li><a href="{{ route('laptop.brand','asus') }}">ASUS</a></li>
                    <li><a href="{{ route('laptop.brand','acer') }}">ACER</a></li>
                    <li><a href="{{ route('laptop.brand','msi') }}">MSI</a></li>
                    <li><a href="{{ route('laptop.brand','lenovo') }}">LENOVO</a></li>
                    <li><a href="{{ route('laptop.brand','dell') }}">DELL</a></li>
                    <li><a href="{{ route('laptop.brand','hp') }}">HP</a></li>
                    <li><a href="{{ route('laptop.brand','lg') }}">LG</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Giá bán</div>
                <ul class="mega-links">
                  <li><a href="/products?category=laptop&price=lt-15000000">Dưới 15 triệu</a></li>
                  <li><a href="/products?category=laptop&price=15-20">Từ 15 đến 20 triệu</a></li>
                  <li><a href="/products?category=laptop&price=gt-20">Trên 20 triệu</a></li>
                </ul>

                <div class="mega-heading mt-4">CPU Intel - AMD</div>
                <ul class="mega-links">
                  <li><a href="/products?category=laptop&cpu=intel-i3">Intel Core i3</a></li>
                  <li><a href="/products?category=laptop&cpu=intel-i5">Intel Core i5</a></li>
                  <li><a href="/products?category=laptop&cpu=intel-i7">Intel Core i7</a></li>
                  <li><a href="/products?category=laptop&cpu=amd-ryzen">AMD Ryzen</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Nhu cầu sử dụng</div>
                <ul class="mega-links">
                  <li><a href="/products?category=laptop&use=design">Đồ hoạ - Studio</a></li>
                  <li><a href="/products?category=laptop&use=student">Học sinh - Sinh viên</a></li>
                  <li><a href="/products?category=laptop&use=thinlight">Mỏng nhẹ cao cấp</a></li>
                </ul>

                <div class="mega-heading mt-4">Linh phụ kiện Laptop</div>
                <ul class="mega-links">
                  <li><a href="/products?category=ram-laptop">Ram laptop</a></li>
                  <li><a href="/products?category=ssd-laptop">SSD laptop</a></li>
                  <li><a href="/products?category=hdd-external">Ổ cứng di động</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Laptop ASUS</div>
                <ul class="mega-links">
                  <li><a href="/products?category=laptop-asus&series=vivobook">Vivobook Series</a></li>
                  <li><a href="/products?category=laptop-asus&series=zenbook">Zenbook Series</a></li>
                  <li><a href="/products?category=laptop-asus&series=tuf">TUF Gaming</a></li>
                </ul>

                <div class="mega-heading mt-4">Laptop ACER</div>
                <ul class="mega-links">
                  <li><a href="/products?category=laptop-acer&series=aspire">Aspire Series</a></li>
                  <li><a href="/products?category=laptop-acer&series=swift">Swift Series</a></li>
                </ul>
              </div>
            </div>
          </div>

          {{-- Màn hình --}}
          <div class="mega-panel" id="panel-monitor">
            <div class="row g-4">
              <div class="col-md-3">
                <div class="mega-heading">Thương hiệu</div>
                <ul class="mega-links">
                  <li><a href="/products?category=monitor&brand=asus">ASUS</a></li>
                  <li><a href="/products?category=monitor&brand=lg">LG</a></li>
                  <li><a href="/products?category=monitor&brand=samsung">Samsung</a></li>
                  <li><a href="/products?category=monitor&brand=aoc">AOC</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Kích thước</div>
                <ul class="mega-links">
                  <li><a href="/products?category=monitor&size=24">23–24"</a></li>
                  <li><a href="/products?category=monitor&size=27">27"</a></li>
                  <li><a href="/products?category=monitor&size=32">32"+</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Tần số quét</div>
                <ul class="mega-links">
                  <li><a href="/products?category=monitor&hz=60-75">60–75Hz</a></li>
                  <li><a href="/products?category=monitor&hz=120-165">120–165Hz</a></li>
                  <li><a href="/products?category=monitor&hz=240">240Hz+</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Độ phân giải</div>
                <ul class="mega-links">
                  <li><a href="/products?category=monitor&res=1080p">Full HD</a></li>
                  <li><a href="/products?category=monitor&res=1440p">2K QHD</a></li>
                  <li><a href="/products?category=monitor&res=2160p">4K UHD</a></li>
                </ul>
              </div>
            </div>
          </div>

          {{-- Điện thoại --}}
          <div class="mega-panel" id="panel-phone">
            <div class="row g-4">
              <div class="col-md-3">
                <div class="mega-heading">Thương hiệu</div>
                <ul class="mega-links">
                  <li><a href="/products?category=phone&brand=apple">Apple</a></li>
                  <li><a href="/products?category=phone&brand=samsung">Samsung</a></li>
                  <li><a href="/products?category=phone&brand=xiaomi">Xiaomi</a></li>
                  <li><a href="/products?category=phone&brand=oppo">OPPO</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Mức giá</div>
                <ul class="mega-links">
                  <li><a href="/products?category=phone&price=lt-5">Dưới 5 triệu</a></li>
                  <li><a href="/products?category=phone&price=5-10">5–10 triệu</a></li>
                  <li><a href="/products?category=phone&price=gt-10">Trên 10 triệu</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="mega-heading">Bộ nhớ</div>
                <ul class="mega-links">
                  <li><a href="/products?category=phone&rom=64">64GB</a></li>
                  <li><a href="/products?category=phone&rom=128">128GB</a></li>
                  <li><a href="/products?category=phone&rom=256">256GB+</a></li>
                </ul>
              </div>
            </div>
          </div>

          {{-- Chuột + Lót chuột --}}
          <div class="mega-panel" id="panel-mouse">
            <div class="row g-4">
              <div class="col-md-4">
                <div class="mega-heading">Chuột</div>
                <ul class="mega-links">
                  <li><a href="/products?category=mouse&type=wireless">Không dây</a></li>
                  <li><a href="/products?category=mouse&type=wired">Có dây</a></li>
                  <li><a href="/products?category=mouse&dpi=high">DPI cao</a></li>
                </ul>
              </div>
              <div class="col-md-4">
                <div class="mega-heading">Lót chuột</div>
                <ul class="mega-links">
                  <li><a href="/products?category=mousepad&size=M">Size M</a></li>
                  <li><a href="/products?category=mousepad&size=L">Size L</a></li>
                  <li><a href="/products?category=mousepad&size=XL">Size XL</a></li>
                </ul>
              </div>
              <div class="col-md-4">
                <div class="mega-heading">Thương hiệu</div>
                <ul class="mega-links">
                  <li><a href="/products?brand=logitech&category=mouse">Logitech</a></li>
                  <li><a href="/products?brand=razer&category=mouse">Razer</a></li>
                  <li><a href="/products?brand=steelseries&category=mouse">SteelSeries</a></li>
                </ul>
              </div>
            </div>
          </div>

          {{-- Tai nghe --}}
          <div class="mega-panel" id="panel-headset">
            <div class="row g-4">
              <div class="col-md-4">
                <div class="mega-heading">Kết nối</div>
                <ul class="mega-links">
                  <li><a href="/products?category=headset&connect=3.5mm">3.5mm</a></li>
                  <li><a href="/products?category=headset&connect=usb">USB</a></li>
                  <li><a href="/products?category=headset&connect=bt">Bluetooth</a></li>
                </ul>
              </div>
              <div class="col-md-4">
                <div class="mega-heading">Kiểu đeo</div>
                <ul class="mega-links">
                  <li><a href="/products?category=headset&type=over-ear">Over-ear</a></li>
                  <li><a href="/products?category=headset&type=in-ear">In-ear</a></li>
                </ul>
              </div>
              <div class="col-md-4">
                <div class="mega-heading">Thương hiệu</div>
                <ul class="mega-links">
                  <li><a href="/products?brand=hyperx&category=headset">HyperX</a></li>
                  <li><a href="/products?brand=steelseries&category=headset">SteelSeries</a></li>
                  <li><a href="/products?brand=corsair&category=headset">Corsair</a></li>
                </ul>
              </div>
            </div>
          </div>

        </div> {{-- /mega-right --}}
      </div>    {{-- /mega-wrap --}}
    </div>
  </div>
</div>


    {{-- Tìm kiếm lớn ở giữa --}}
    <form class="flex-grow-1 search-wrap" role="search" action="/products" method="get">
      <div class="input-group">
        <input
          class="form-control form-control-lg search-input"
          type="search" name="q" placeholder="Bạn cần tìm gì?"
          value="{{ request('q') }}"
          aria-label="Tìm kiếm"
        >
        <button class="btn btn-search" type="submit" aria-label="Tìm">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>

    {{-- nhóm icon + text bên phải --}}
    <div class="d-none d-lg-flex align-items-center ms-auto gap-4 top-links">
      <a class="toplink" href="tel:19005301">
        <i class="bi bi-headset"></i>
        <span class="label">Hotline<br><strong>1900.5301</strong></span>
      </a>

      <a class="toplink" href="/showrooms">
        <i class="bi bi-geo-alt"></i>
        <span class="label">Hệ thống<br>Showroom</span>
      </a>

      <a class="toplink" href="/orders/lookup">
        <i class="bi bi-receipt"></i>
        <span class="label">Tra cứu<br>đơn hàng</span>
      </a>

      @php($cartCount = $cartCount ?? (session('cart_count') ?? 0))
      <a class="toplink position-relative" href="/cart">
        <i class="bi bi-cart"></i>
        <span class="label">Giỏ<br>hàng</span>
        @if ($cartCount > 0)
          <span class="badge cart-badge">{{ $cartCount }}</span>
        @endif
      </a>

        @auth
            <form action="{{ route('logout') }}" method="post" class="d-inline">
                @csrf
                <button class="toplink btn btn-link p-0 text-decoration-none">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="label">Đăng<br>xuất</span>
                </button>
            </form>
        @else
            <a class="toplink" href="{{ route('login') }}">
                <i class="bi bi-person"></i>
                <span class="label">Đăng<br>nhập</span>
            </a>
        @endauth
    </div>

    {{-- toggler cho mobile --}}
    <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- menu mobile (tùy bạn thêm item) --}}
    <div class="collapse navbar-collapse mt-2" id="topNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item d-lg-none"><a class="nav-link text-white" href="/categories">Danh mục</a></li>
        <li class="nav-item d-lg-none"><a class="nav-link text-white" href="/orders/lookup">Tra cứu đơn hàng</a></li>
        <li class="nav-item d-lg-none"><a class="nav-link text-white" href="/cart">Giỏ hàng ({{ $cartCount }})</a></li>
        <li class="nav-item d-lg-none"><a class="nav-link text-white" href="/login">Đăng nhập</a></li>
      </ul>
    </div>

  </div>
</nav>
