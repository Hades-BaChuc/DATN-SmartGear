<form method="get" class="vstack gap-3">

  <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Từ khoá...">

  <div class="row g-2">
    <div class="col"><input class="form-control" type="number" name="min" value="{{ request('min') }}" placeholder="Giá từ"></div>
    <div class="col"><input class="form-control" type="number" name="max" value="{{ request('max') }}" placeholder="đến"></div>
  </div>

  <select class="form-select" name="author">
    <option value="">-- Thương hiệu --</option>
    @foreach($brands as $a)
      <option value="{{ $a->id }}" @selected(request('author')==$a->id)>{{ $a->name }}</option>
    @endforeach
  </select>

  <select class="form-select" name="publisher">
    <option value="">-- Nhà cung cấp --</option>
    @foreach($suppliers as $p)
      <option value="{{ $p->id }}" @selected(request('publisher')==$p->id)>{{ $p->name }}</option>
    @endforeach
  </select>

  <select class="form-select" name="sort">
    <option value="">-- Sắp xếp --</option>
    <option value="newest"     @selected(request('sort')=='newest')>Mới nhất</option>
    <option value="price_asc"  @selected(request('sort')=='price_asc')>Giá ↑</option>
    <option value="price_desc" @selected(request('sort')=='price_desc')>Giá ↓</option>
    <option value="rating"     @selected(request('sort')=='rating')>Đánh giá</option>
  </select>

  <button class="btn btn-primary">Lọc</button>
</form>
