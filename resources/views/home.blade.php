@extends('layouts.app')
@section('title','Trang chủ')

@section('content')

{{-- HERO --}}
<section class="home-hero text-white">
  <video class="home-hero-video" autoplay loop muted playsinline poster="/images/hero-poster.jpg">
    <source src="/videos/hero.mp4" type="video/mp4">
  </video>
  <div class="container text-center hero-inner">
    <p class="overline mb-2">DESIGNED BY PROS. BUILT TO WIN.</p>
    <h1 class="display-4 hero-title mb-3">VANGUARD PRO 96</h1>
    <a href="/products?vanguard-pro-96" class="btn btn-cta">Shop now</a>
  </div>
  <div class="hero-fade"></div>
</section>

{{-- TABS --}}
<section class="home-section home-tabs-wrap text-white">
  <div class="container">
    <ul class="nav nav-tabs home-tabs justify-content-center gap-3 border-0 mb-3">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-cats">Product Categories</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-featured">Featured Products</button></li>
    </ul>

    <div class="tab-content">
      {{-- Product Categories --}}
      <div class="tab-pane fade show active" id="tab-cats">
        <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3">
          @php
            $cats = [
              ['title'=>'Gaming Keyboards','img'=>'/images/cat-keyboard.jpg'],
              ['title'=>'Gaming PCs','img'=>'/images/cat-pc.jpg'],
              ['title'=>'Memory','img'=>'/images/cat-ram.jpg'],
              ['title'=>'Gaming Headsets','img'=>'/images/cat-headset.jpg'],
              ['title'=>'Power Supplies','img'=>'/images/cat-psu.jpg'],
              ['title'=>'Gaming Furniture','img'=>'/images/cat-furniture.jpg'],
              ['title'=>'PC Cases','img'=>'/images/cat-case.jpg'],
              ['title'=>'Custom Lab','img'=>'/images/cat-lab.jpg'],
              ['title'=>'CPU Coolers','img'=>'/images/cat-cooler.jpg'],
            ];
          @endphp
          @foreach($cats as $c)
            <div class="col">
              <a href="/products?category={{ Str::slug($c['title']) }}" class="tile-card">
                <img class="bg-img" src="{{ $c['img'] }}" alt="{{ $c['title'] }}">
                <div class="tile-overlay">
                  <div class="small text-accent fw-semibold">SHOP NOW</div>
                  <div class="tile-title">{{ $c['title'] }}</div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>

      {{-- Featured Products --}}
      <div class="tab-pane fade" id="tab-featured">
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
          @for($i=1;$i<=8;$i++)
          <div class="col">
            <a href="/products/{{ $i }}" class="prod-card">
              <div class="p-3">
                <img src="/images/prod-{{ $i }}.jpg" class="w-100 ratio-4x3 rounded mb-2" alt="Product {{ $i }}">
                <div class="text-white-50 small">Gaming Gear</div>
                <div class="text-white fw-semibold">Product name {{ $i }}</div>
                <div class="text-accent fw-bold mt-1">$199.00</div>
              </div>
            </a>
          </div>
          @endfor
        </div>
      </div>
    </div>
  </div>
</section>

{{-- GUIDES --}}
<section class="home-section home-guides text-white">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between mb-3">
      <h2 class="section-title mb-0">GUIDES, TIPS & TRICKS</h2>
      <div class="section-tabs text-white-50">FEATURED ARTICLES <span class="mx-3 opacity-50">|</span> LATEST ARTICLES</div>
    </div>

    <div class="row g-3">
      <div class="col-lg-4">
        <a class="guide-tile big" href="#">
          <img src="/images/guide-1.jpg" alt="">
          <div class="g-overlay">
            <div class="g-kicker">BLOG</div>
            <div class="g-title">Series: Performance, Customization & Innovation in One</div>
          </div>
        </a>
      </div>
      <div class="col-lg-4">
        <a class="guide-tile big" href="#">
          <img src="/images/guide-2.jpg" alt="">
          <div class="g-overlay">
            <div class="g-kicker">PATCH NOTES</div>
            <div class="g-title">iCUE 5.34.66</div>
          </div>
        </a>
      </div>
      <div class="col-lg-4">
        <a class="guide-tile big" href="#">
          <img src="/images/guide-3.jpg" alt="">
          <div class="g-overlay">
            <div class="g-kicker">BUYER’S GUIDES</div>
            <div class="g-title">Best Headsets for PS5 in 2025</div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

{{-- WHY BUY DIRECT --}}
<section class="home-section why-direct text-white">
  <div class="container">
    <div class="row g-4 text-center justify-content-center">
      <div class="col-6 col-md-3 col-lg-2">
        <div class="feature-pill"><i class="bi bi-stars"></i><span>EXCLUSIVE PRODUCTS & BUNDLES</span></div>
      </div>
      <div class="col-6 col-md-3 col-lg-2">
        <div class="feature-pill"><i class="bi bi-truck"></i><span>SHIPS FREE NEXT BUSINESS DAY*</span></div>
      </div>
      <div class="col-6 col-md-3 col-lg-2">
        <div class="feature-pill"><i class="bi bi-chat-dots"></i><span>LIVE CHAT WITH PRODUCT SPECIALISTS</span></div>
      </div>
      <div class="col-6 col-md-3 col-lg-2">
        <div class="feature-pill"><i class="bi bi-arrow-counterclockwise"></i><span>60-DAYS RISK FREE RETURNS</span></div>
      </div>
    </div>
  </div>
</section>

{{-- SPECIAL OFFERS / MOSAIC --}}
<section class="home-section specials text-white">
  <div class="container">
    <div class="special-grid">
      <a class="spec-tile tall" href="#">
        <img src="/images/special-1.jpg" alt="">
        <div class="s-overlay"><div class="s-title">CORSAIR CUSTOM LAB</div></div>
      </a>
      <a class="spec-tile" href="#">
        <img src="/images/special-2.jpg" alt="">
        <div class="s-overlay"><div class="s-title">SPECIAL OFFERS</div></div>
      </a>
      <a class="spec-tile" href="#">
        <img src="/images/special-3.jpg" alt="">
        <div class="s-overlay"><div class="s-title">PC BUILDER</div></div>
      </a>
    </div>
  </div>
</section>

{{-- NEWSLETTER / SOCIAL (đơn giản) --}}
<section class="home-section newsletter text-white">
  <div class="container">
    <div class="row g-3 align-items-center">
      <div class="col-md-6">
        <h3 class="mb-2">Get special offers & product news</h3>
        <form class="d-flex gap-2">
          <input type="email" class="form-control form-control-lg bg-transparent text-white border-secondary" placeholder="Email Address">
          <button class="btn btn-cta">Sign up</button>
        </form>
      </div>
      <div class="col-md-6 text-md-end">
        <div class="d-inline-flex gap-3 fs-4">
          <i class="bi bi-tiktok"></i><i class="bi bi-facebook"></i><i class="bi bi-instagram"></i><i class="bi bi-youtube"></i><i class="bi bi-twitch"></i><i class="bi bi-discord"></i>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
