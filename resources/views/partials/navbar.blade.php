<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
<div class="container">
<a class="navbar-brand fw-bold" href="/">Bookshop</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="topNav">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
<li class="nav-item"><a class="nav-link" href="/books">Sách</a></li>
</ul>
<form class="d-flex me-3" role="search" action="/books" method="get">
<input class="form-control" type="search" name="q" placeholder="Tìm sách, tác giả…" value="{{ request('q') }}">
</form>
@php($cartCount = $cartCount ?? (session('cart_count') ?? 0))
<a href="/cart" class="btn btn-outline-dark position-relative">
<i class="bi bi-cart"></i>
<span class="ms-2">Giỏ hàng</span>
@if($cartCount>0)
<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
@endif
</a>
</div>
</div>
</nav>