@extends('layouts.app')
@section('title','Sách mới')
@section('content')
<div class="container py-4">
  <div class="row g-3">
    @foreach($books as $b)
      <div class="col-6 col-md-3">
        <div class="card h-100">
          <img src="{{ $b->cover_image }}" class="card-img-top" alt="{{ $b->title }}">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title flex-grow-1">{{ $b->title }}</h6>
            <div class="fw-bold">{{ number_format($b->price) }}₫</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mt-3">{{ $books->links() }}</div>
</div>
@endsection
