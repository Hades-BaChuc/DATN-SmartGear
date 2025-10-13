<footer class="site-footer text-white">
  <div class="container footer-top">
    <div class="row g-4 align-items-start">
      {{-- Brand + newsletter --}}
      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <i class="bi bi-lightning-charge-fill fs-3 text-accent"></i>
          <span class="fw-bold">PRODUCTSHOP</span>
        </div>
        <p class="text-white-50 small mb-3">
          Get special offers, exclusive product news, and event info straight to your inbox.
        </p>
        <form class="footer-signup d-flex gap-2">
          <input type="email" class="form-control form-control-lg footer-input" placeholder="Email Address">
          <button class="btn btn-cta">SIGN UP</button>
        </form>
        <div class="footer-social d-inline-flex gap-3 fs-4 mt-3">
          <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
          <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          <a href="#" aria-label="Twitch"><i class="bi bi-twitch"></i></a>
          <a href="#" aria-label="Discord"><i class="bi bi-discord"></i></a>
        </div>
      </div>

      {{-- Link columns --}}
      <div class="col-lg-8">
        <div class="row g-4 footer-links">
          <div class="col-6 col-md-3">
            <div class="footer-heading">SHOP</div>
            <ul class="list-unstyled mb-0">
              <li><a href="#">New Products</a></li>
              <li><a href="#">Special Offers</a></li>
              <li><a href="#">Best Sellers</a></li>
              <li><a href="#">Exclusives</a></li>
              <li><a href="#">Where to Buy</a></li>
              <li><a href="#">Refurbished</a></li>
              <li><a href="#">Business Solutions</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3">
            <div class="footer-heading">EXPLORE</div>
            <ul class="list-unstyled mb-0">
              <li><a href="#">PC Builder</a></li>
              <li><a href="#">Innovation</a></li>
              <li><a href="#">Design Your Loop</a></li>
              <li><a href="#">Ambassadors</a></li>
              <li><a href="#">Wallpaper</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3">
            <div class="footer-heading">CORSAIR</div>
            <ul class="list-unstyled mb-0">
              <li><a href="#">About</a></li>
              <li><a href="#">Investor Relations</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Press Room</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Blog</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3">
            <div class="footer-heading">SUPPORT</div>
            <ul class="list-unstyled mb-0">
              <li><a href="#">Downloads</a></li>
              <li><a href="#">Web Hub</a></li>
              <li><a href="#">Firmware Utility</a></li>
              <li><a href="#">Customer Support</a></li>
              <li><a href="#">Warranty</a></li>
              <li><a href="#">Shipping/RMA</a></li>
              <li><a href="#">Terms of Sale</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div> <!-- /row -->
  </div> <!-- /container -->

  <hr class="footer-divider">

  <div class="container footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
    <div class="small text-white-50">
      Copyright © 1996 - {{ date('Y') }} PRODUCTSHOP. All rights reserved.
    </div>
    <ul class="list-inline small mb-0 footer-legal">
      <li class="list-inline-item"><a href="#">Sitemap</a></li>
      <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
      <li class="list-inline-item"><a href="#">Terms of Use</a></li>
      <li class="list-inline-item"><a href="#">Cookie Settings</a></li>
    </ul>
  </div>
</footer>
