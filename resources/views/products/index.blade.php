@extends('layouts.app')
<button class="btn btn-dark w-100" type="submit"><i class="bi bi-funnel me-1"></i> Lọc</button>
</form>
</div>
</aside>


<section class="col-md-9">
<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h4 mb-0">Tất cả sách</h1>
<div class="text-muted small">{{ ($total ?? 12) }} kết quả</div>
</div>


<div class="row g-3">
@php($list = $products ?? [
['id'=>1,'name'=>'Dune','author'=>'Frank Herbert','price'=>189000,'cover'=>'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop'],
['id'=>2,'name'=>'Atomic Habits','author'=>'James Clear','price'=>159000,'cover'=>'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=600&auto=format&fit=crop'],
['id'=>3,'name'=>'Sapiens','author'=>'Yuval Noah Harari','price'=>210000,'cover'=>'https://images.unsplash.com/photo-1519682337058-a94d519337bc?q=80&w=600&auto=format&fit=crop'],
['id'=>4,'name'=>'Clean Code','author'=>'Robert C. Martin','price'=>259000,'cover'=>'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?q=80&w=600&auto=format&fit=crop'],
['id'=>5,'name'=>'Charlotte\'s Web','author'=>'E. B. White','price'=>99000,'cover'=>'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?q=80&w=600&auto=format&fit=crop'],
['id'=>6,'name'=>'English Grammar in Use','author'=>'Raymond Murphy','price'=>175000,'cover'=>'https://images.unsplash.com/photo-1526312426976-593c2d0fb1df?q=80&w=600&auto=format&fit=crop']
])
@foreach($list as $b)
<div class="col-6 col-lg-4">
<div class="card h-100">
<img class="card-img-top book-cover" src="{{ $b['cover'] }}" alt="{{ $b['name'] }}">
<div class="card-body d-flex flex-column">
<a href="/products/{{ $b['id'] }}" class="stretched-link text-decoration-none text-dark">
<h3 class="h6 line-clamp-2 mb-1">{{ $b['name'] }}</h3>
</a>
<div class="text-muted small mb-2">{{ $b['author'] }}</div>
<div class="mt-auto fw-semibold">{{ number_format($b['price'],0,',','.') }} ₫</div>
</div>
</div>
</div>
@endforeach
</div>


<!-- Pagination placeholder -->
<nav class="mt-4" aria-label="Pagination">
<ul class="pagination justify-content-center">
<li class="page-item disabled"><span class="page-link">«</span></li>
<li class="page-item active"><span class="page-link">1</span></li>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item"><a class="page-link" href="#">»</a></li>
</ul>
</nav>
</section>
</div>
@endsection