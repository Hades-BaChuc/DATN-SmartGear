@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Giỏ hàng</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(empty($cart))
    <p class="text-muted">Giỏ hàng trống.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
  @else
    <form method="POST" action="{{ route('cart.clear') }}" class="mb-3">
      @csrf
      <button class="btn btn-outline-danger btn-sm">Xoá toàn bộ</button>
    </form>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Sản phẩm</th>
            <th class="text-end" style="width: 140px;">Đơn giá</th>
            <th class="text-center" style="width: 100px;">SL</th>
            <th class="text-end" style="width: 140px;">Thành tiền</th>
            <th style="width: 80px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $row)
            @php($p = $row['product'])
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="{{ $p->cover_image ?? 'https://picsum.photos/100/80?random='.$p->id }}" class="me-2 rounded" width="64" alt="">
                  <div>
                    <a href="{{ route('products.show',$p->id) }}" class="fw-semibold text-decoration-none">{{ $p->name }}</a>
                    <div class="text-muted small">{{ $p->brand->name ?? '—' }}</div>
                  </div>
                </div>
              </td>
              <td class="text-end">{{ number_format($row['price'],0,',','.') }}₫</td>
              <td class="text-center">{{ $row['qty'] }}</td>
              <td class="text-end">{{ number_format($row['qty'] * $row['price'],0,',','.') }}₫</td>
              <td>
                <form method="POST" action="{{ route('cart.remove',$p->id) }}">
                  @csrf
                  <button class="btn btn-sm btn-outline-secondary">Xoá</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Tổng cộng</th>
            <th class="text-end h5">{{ number_format($total,0,',','.') }}₫</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="text-end">
      <a href="#" class="btn btn-success disabled">Thanh toán (demo)</a>
    </div>
  @endif
</div>
@endsection
