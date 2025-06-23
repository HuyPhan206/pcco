<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #007bff;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .preview-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
@extends('layouts.admin')

@section('content')
    <h2 class="text-center mb-4">Sửa Sản phẩm</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá (VNĐ)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required>
        </div>
        <div class="mb-3">
            <label for="discount_price" class="form-label">Giá giảm (nếu có)</label>
            <input type="number" class="form-control @error('discount_price') is-invalid @enderror" id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01">
            @error('discount_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Số lượng trong kho</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" step="1" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh hiện tại</label><br>
            <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}"><br><br>
            <label for="image" class="form-label">Thay đổi hình ảnh (Tối đa 10MB, nếu cần)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật Sản phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
    </form>

    <script>
        document.getElementById('productForm').addEventListener('submit', function (event) {
            const stockInput = document.getElementById('stock');
            const stockValue = stockInput.value;

            // Check if the stock value is an integer
            if (!Number.isInteger(Number(stockValue))) {
                event.preventDefault();
                alert('Số lượng trong kho phải là một số nguyên.');
                stockInput.focus();
            }
        });
    </script>
@endsection

   <script>
    document.getElementById('price').addEventListener('input', checkDiscountPrice);
    document.getElementById('discount_price').addEventListener('input', checkDiscountPrice);

    function checkDiscountPrice() {
        const price = document.getElementById('price').value;
        const discountPrice = document.getElementById('discount_price').value;

        if (discountPrice && parseFloat(discountPrice) >= parseFloat(price)) {
            document.getElementById('discount_price').value = '';
            alert('Giá giảm không được lớn hơn hoặc bằng giá gốc!');
        }
    }
</script>