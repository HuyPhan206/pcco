@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h1>Thêm Nhân viên</h1>
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}">
                        <label class="form-check-label" for="role-{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
                @error('roles')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
        </form>
    </div>
@endsection