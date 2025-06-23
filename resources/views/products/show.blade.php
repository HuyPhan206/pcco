@extends('layouts.app')

@section('content')
    <div class="container py-5">
        @if ($product)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Sản phẩm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            @if ($product->image && Storage::disk('public')->exists($product->image))
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 400px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded p-5" style="height: 400px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-muted">Hình ảnh không khả dụng. Vui lòng liên hệ để biết thêm chi tiết!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="card-title text-primary mb-3">{{ $product->name }}</h2>
                            <div class="mb-4">
                                <h4 class="text-muted">Thông tin sản phẩm</h4>
                                <p><strong>Danh mục:</strong> {{ $product->category?->name ?? 'Không có danh mục' }}</p>
                                <p><strong>Giá:</strong> 
                                    <span class="text-danger">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                    @if ($product->discount_price)
                                        <del class="text-muted ms-2">{{ number_format($product->price, 0, ',', '.') }}đ</del>
                                        <span class="badge bg-success ms-2">{{ number_format($product->discount_price, 0, ',', '.') }}đ</span>
                                    @endif
                                </p>
                                <p><strong>Số lượng trong kho:</strong> {{ $product->stock > 0 ? $product->stock : 'Hết hàng' }}</p>
                                <p><strong>Mô tả:</strong> {{ $product->description ?? 'Không có mô tả.' }}</p>
                            </div>

                            @if ($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2 mb-3">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-25" required>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                                    </button>
                                </form>
                            @else
                                <p class="text-danger mb-3">Sản phẩm tạm thời hết hàng!</p>
                            @endif

                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h3 class="text-warning">Không có sản phẩm để hiển thị!</h3>
                <p class="text-muted">Sản phẩm bạn đang tìm kiếm không tồn tại. Vui lòng kiểm tra lại hoặc quay lại trang chính.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Quay lại danh sách sản phẩm</a>
            </div>
        @endif
        <!-- Debug -->
        
    </div>
@endsection