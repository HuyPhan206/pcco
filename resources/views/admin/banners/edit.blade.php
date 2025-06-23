<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Banner - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #007bff; }
        .navbar { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .banner-image { width: 200px; height: auto; }
    </style>
</head>
<body>
@extends('layouts.admin')

@section('content')
    <h2 class="text-center mb-4">Sửa Banner</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $banner->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh hiện tại</label><br>
            <img src="{{ asset('storage/' . $banner->image) }}" class="product-image" alt="{{ $banner->title }}"><br><br>
            <label for="image" class="form-label">Thay đổi hình ảnh (Tối đa 20MB, nếu cần)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả (giá, phụ đề, ...)</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $banner->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Loại Banner</label>
            <select class="form-control" id="type" name="type" required>
                <option value="main" {{ $banner->type == 'main' ? 'selected' : '' }}>Banner Chính</option>
                <option value="small" {{ $banner->type == 'small' ? 'selected' : '' }}>Banner Phụ</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Vị trí (1: Chính, 2-6: Phụ)</label>
            <input type="number" class="form-control" id="position" name="position" value="{{ old('position', $banner->position) }}" min="1" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Hiển thị</label>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật Banner</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>