<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Bookshop')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
.line-clamp-2 {display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.book-cover {aspect-ratio:3/4; object-fit:cover}
</style>
@stack('styles')
</head>
<body class="bg-light">
@include('partials.navbar')
<main class="container py-4">
@includeWhen(Session::has('success') || Session::has('error'), 'partials.alerts')
@yield('content')
</main>
@include('partials.footer')


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Simple qty stepper handler (works for cart & detail)
document.addEventListener('click', function(e){
const btn = e.target.closest('[data-step]');
if(!btn) return;
const wrap = btn.closest('[data-qty-wrap]');
const input = wrap.querySelector('input[type="number"]');
const step = btn.dataset.step === 'inc' ? 1 : -1;
const min = parseInt(input.min||1), max = parseInt(input.max||999);
let val = parseInt(input.value||1) + step; if(val<min) val=min; if(val>max) val=max; input.value = val;
input.dispatchEvent(new Event('change'));
});
</script>
@stack('scripts')
</body>
</html>