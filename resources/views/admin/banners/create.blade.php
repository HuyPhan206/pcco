<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Banner - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #007bff; }
        .navbar { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
@extends('layouts.admin')

@section('content')
    <h2 class="text-center mb-4">Thêm Banner</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh (Tối đa 10MB)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả (giá, phụ đề, ...)</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Loại Banner</label>
            <select class="form-control" id="type" name="type" required>
                <option value="main">Banner Chính</option>
                <option value="small">Banner Phụ</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Vị trí (1: Chính, 2-6: Phụ)</label>
            <input type="number" class="form-control" id="position" name="position" value="{{ old('position', 1) }}" min="1" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Hiển thị</label>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Banner</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>