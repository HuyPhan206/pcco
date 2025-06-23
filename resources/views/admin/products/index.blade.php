<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #007bff;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .product-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
@extends('layouts.admin')

@section('content')
    <h2 class="text-center mb-4">Quản lý sản phẩm</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ url('/') }}" class="btn btn-primary mb-3"><i class="bi bi-chevron-compact-left"></i></a>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3"><i class="bi bi-bag-plus-fill"></i> Thêm sản phẩm</a>
    <div class="card content-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Giá giảm</th>
                        <th>Kho</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? 'Không có danh mục' }}</td>
                            <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                            <td>{{ $product->discount_price ? number_format($product->discount_price, 0, ',', '.') . 'đ' : 'N/A' }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm me-2">Sửa</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>