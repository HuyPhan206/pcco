<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTG Shop - Thông Tin Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .addresses-container {
            margin-top: 40px;
            padding: 0 15px;
        }
        .addresses-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .sidebar {
            flex: 0 0 250px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .sidebar .user-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .sidebar .user-info span {
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            font-size: 0.95rem;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .sidebar ul li a:hover {
            color: #007bff;
        }
        .sidebar ul li.active a {
            color: #ff0000;
            font-weight: bold;
        }
        .main-content {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .main-content h2 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 0.95rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }
        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 0.95rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .address-list {
            margin-bottom: 30px;
        }
        .address-item {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            position: relative;
        }
        .address-item .default-label {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .address-item p {
            margin: 0;
            font-size: 0.95rem;
            color: #333;
        }
        .address-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 10px;
        }
        .address-actions a, .address-actions form {
            display: inline-block;
        }
        .address-actions a.btn, .address-actions button {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
        .save-btn {
            background-color: #ff0000;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .save-btn:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    @extends('layouts.app')
@section('content')
    <div class="container addresses-container">
        <div class="addresses-row">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-info">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/40?text=' . Auth::user()->name[0] }}" alt="User Avatar">
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('user.profile') }}"><i class="bi bi-person-fill"></i> Thông tin tài khoản</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('user.addresses') }}"><i class="bi bi-geo-alt-fill"></i> Sổ địa chỉ</a>
                    </li>
                    <li>
                        <a href="{{route('orders.index')}}"><i class="bi bi-cart-fill"></i> Quản lý đơn hàng</a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-eye-fill"></i> Sản phẩm đã xem</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <h2>Sổ địa chỉ</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- List of Addresses -->
                <div class="address-list">
                    @if ($addresses->isEmpty())
                        <p>Chưa có địa chỉ nào. Vui lòng thêm địa chỉ mới!</p>
                    @else
                        @foreach ($addresses as $address)
                            <div class="address-item">
                                @if ($address->is_default)
                                    <div class="default-label">Địa chỉ mặc định</div>
                                @endif
                                <p>{{ $address->address }}</p>
                                <p>{{ $address->city }}, {{ $address->country }}</p>
                                <p>Mã bưu điện: {{ $address->postal_code }}</p>
                                <div class="address-actions">
                                    <a href="{{ route('user.addresses.edit', $address) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <form action="{{ route('user.addresses.delete', $address) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                    @if (!$address->is_default)
                                        <form action="{{ route('user.addresses.set-default', $address) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Đặt làm mặc định</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Add/Edit Address Form -->
                <h3>{{ isset($address) ? 'Sửa địa chỉ' : 'Thêm địa chỉ mới' }}</h3>
                <form action="{{ isset($address) ? route('user.addresses.update', $address) : route('user.addresses.store') }}" method="POST">
                    @csrf
                    @if (isset($address))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" id="address" name="address" value="{{ isset($address) ? $address->address : old('address') }}" required>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">Thành phố</label>
                        <input type="text" id="city" name="city" value="{{ isset($address) ? $address->city : old('city') }}" required>
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="country">Quốc gia</label>
                        <input type="text" id="country" name="country" value="{{ isset($address) ? $address->country : old('country') }}" required>
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Mã bưu điện</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ isset($address) ? $address->postal_code : old('postal_code') }}" required>
                        @error('postal_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_default" {{ isset($address) && $address->is_default ? 'checked' : '' }}>
                            Đặt làm địa chỉ mặc định
                        </label>
                    </div>
                    <button type="submit" class="save-btn">{{ isset($address) ? 'Cập nhật' : 'Thêm địa chỉ' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
    </body>
    </html>