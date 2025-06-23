@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
         <h2 class="text-center">Quản lý Người Dùng</h2>

        <a href="{{ url('/') }}" class="btn btn-primary mb-3"><i class="bi bi-chevron-compact-left"></i></a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3"><i class="bi bi-person-fill-add"></i> Thêm Người Dùng</a>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light rounded shadow-sm mb-4">
                <li class="breadcrumb-item active h4" aria-current="page">Người Dùng</li>
            </ol>
        </nav>
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i> Danh sách Người Dùng
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Ngày tạo</th>
                                <th class="text-center" style="width: 15%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role == 'admin' ? 'bg-success' : 'bg-info' }} text-white">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                                        Không có người dùng nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection