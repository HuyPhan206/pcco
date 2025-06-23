<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #007bff; }
        .navbar { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .cart-table { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
@extends('layouts.app')
@section('content')
    <!-- Giỏ hàng -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Giỏ hàng của bạn</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-primary mb-3"><i class="bi bi-person-fill-add"></i> Đơn Hàng</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card cart-table">
            <div class="card-body">
            @if (count($cart) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($cart as $id => $item)
    <tr>
        <td>
            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/default.jpg') }}" 
                    alt="{{ $item['name'] }}" 
                    style="width: 50px; height: 50px; object-fit: cover;" 
                    onerror="this.src='{{ asset('images/default.jpg') }}';">
        </td>
        <td>{{ $item['name'] }}</td>
        <td>{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
        <td>
            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                @csrf
                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 60px;">
                <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
            </form>
        </td>
        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</td>
        <td>
            <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
            </form>
        </td>
    </tr>
    @php $total += $item['price'] * $item['quantity']; @endphp
@empty
    <tr>
        <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống.</td>
    </tr>
@endforelse
        </tbody>
    </table>
    <div class="text-end">
        <h5>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</h5>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Thanh toán</a>
        </form>
    </div>
@else
    <p class="text-center">Giỏ hàng của bạn đang trống.</p>
@endif
        </div>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('/') }}'">Quay lại mua sắm</button>
        </div>
    </div>
@endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                
