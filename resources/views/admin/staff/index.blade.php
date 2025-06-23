@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h1>Quản lý Nhân viên</h1>
        <a href="{{ url('/') }}" class="btn btn-primary mb-3"><i class="bi bi-chevron-compact-left"></i></a>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary mb-3">Thêm nhân viên</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staffs as $staff)
                    <tr>
                        <td>{{ $staff->id }}</td>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>
                            @foreach ($staff->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có nhân viên nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection