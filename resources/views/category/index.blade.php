@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1>{{ $category->name }}</h1>
        <a href="{{ url('/') }}" class="btn btn-primary mb-3"><i class="bi bi-chevron-compact-left"></i></a>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.jpg') }}" 
                             class="card-img-top" alt="{{ $product->name }}" 
                             style="height: 200px; object-fit: cover;" 
                             onerror="this.src='{{ asset('images/default.jpg') }}';">
                        <div class="card-body">
                           <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">
                                        Giá: {{ number_format($product->price, 0, ',', '.') }}đ
                                        @if ($product->discount_price)
                                            <br>Giá giảm: {{ number_format($product->discount_price, 0, ',', '.') }}đ
                                        @endif
                                    </p>
                                    <p class="card-text">Số lượng: {{ $product->stock }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary mt-1">Thêm vào giỏ</button>
                                    </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                </div>
            @endforelse
        </div>
        {{ $products->links() }} <!-- Phân trang -->
    </div>
@endsection