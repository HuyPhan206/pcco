@extends('layouts.admin')

@section('content')
    <h2 class="text-center mb-4">Quản lý Banner</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ url('/') }}" class="btn btn-primary mb-3"><i class="bi bi-chevron-compact-left"></i></a>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary mb-3"><i class="bi bi-images"></i> Thêm Banner</a>
    <div class="card content-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th>Loại</th>
                        <th>Vị trí</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banners as $banner)
                        <tr>
                            <td>{{ $banner->title }}</td>
                            <td><img src="{{ asset('storage/' . $banner->image) }}" class="product-image" alt="{{ $banner->title }}"></td>
                            <td>{{ $banner->description ?? 'N/A' }}</td>
                            <td>{{ $banner->type == 'main' ? 'Chính' : 'Phụ' }}</td>
                            <td>{{ $banner->position }}</td>
                            <td>{{ $banner->is_active ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td>
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-warning btn-sm me-2">Sửa</a>
                                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có banner nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection