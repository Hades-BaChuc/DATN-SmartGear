<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Productshop')</title>

  <!-- Preconnect for fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap & Icons (CDN) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- App CSS (static, cache-busted) -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">

  @stack('styles')
</head>
<body>

  <header>
    @include('partials.navbar')
  </header>

  <main class="container py-4" role="main">
    @includeWhen(Session::has('success') || Session::has('error'), 'partials.alerts')
    @yield('content')
  </main>

  @include('partials.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- App JS: qty stepper + navbar shadow -->
  <script>
    (function () {
      // qty stepper
      document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-step]');
        if (!btn) return;
        const wrap = btn.closest('[data-qty-wrap]');
        const input = wrap?.querySelector('input[type="number"]');
        if (!input) return;
        const step = btn.dataset.step === 'inc' ? 1 : -1;
        const min = parseInt(input.min || 1, 10);
        const max = parseInt(input.max || 999, 10);
        let val = parseInt(input.value || 1, 10) + step;
        input.value = Math.min(Math.max(val, min), max);
        input.dispatchEvent(new Event('change'));
      });

      // navbar shadow on scroll
      const nav = document.querySelector('nav.navbar');
      const onScroll = () => nav && nav.classList.toggle('scrolled', window.scrollY > 2);
      onScroll(); window.addEventListener('scroll', onScroll);
    })();
  </script>

  @stack('scripts')
</body>
</html>
