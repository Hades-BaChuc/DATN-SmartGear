{{-- Top bar giống hình GEARVN --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-gearvn sticky-top py-2">
  <div class="container-xl align-items-center gap-3">

    {{-- Logo / Brand (có thể thay bằng <img> nếu bạn có file logo) --}}
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
      {{-- <img src="/logo.svg" alt="Productshop" height="28"> --}}
      Productshop
    </a>

    {{-- Nút Danh mục + Mega dropdown --}}
<div class="dropdown position-static d-none d-lg-block">
  <button class="btn btn-menu dropdown-toggle d-inline-flex align-items-center gap-2"
          data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
    <i class="bi bi-list fs-5"></i>
    <span class="fw-semibold">Danh mục</span>
  </button>

  <div class="dropdown-menu dropdown-mega p-3 mt-2">
    <div class="container-xl">
      <div class="cat-grid">

        {{-- Ví dụ item (có thể loop @foreach $categories as $cat) --}}
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-laptop"></i> Laptop</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-pc-display"></i> Laptop Gaming</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-pc"></i> PC GVN</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-cpu"></i> Main, CPU, VGA</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-hdd"></i> Case, Nguồn, Tản</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-device-hdd"></i> Ổ cứng, RAM, Thẻ nhớ</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-mic"></i> Loa, Micro, Webcam</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-display"></i> Màn hình</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-keyboard"></i> Bàn phím</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-mouse"></i> Chuột + Lót chuột</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-headphones"></i> Tai nghe</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-controller"></i> Handheld, Console</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-usb-c"></i> Phụ kiện (Hub, sạc…)</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="#" class="cat-item">
          <span class="left"><i class="bi bi-bag-check"></i> Dịch vụ & thông tin khác</span>
          <i class="bi bi-chevron-right"></i>
        </a>

      </div>
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

      <a class="toplink" href="/login">
        <i class="bi bi-person"></i>
        <span class="label">Đăng<br>nhập</span>
      </a>
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
