<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTG Shop - Thông Tin Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>

        #backToTop {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 100;
            display: none;
            background-color: #333;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            transition: opacity 0.3s ease;
        }

        #backToTop:hover {
            background-color: #555;
        }
        .profile-container {
            margin-top: 40px;
            padding: 0 15px;
        }
        .profile-row {
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
        .form-group input[type="email"],
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 0.95rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group input[type="email"] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .form-group .gender-options {
            display: flex;
            gap: 20px;
        }
        .form-group .gender-options label {
            font-weight: normal;
            margin-bottom: 0;
        }
        .form-group .phone-verification {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-group .phone-verification a {
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }
        .form-group .phone-verification a:hover {
            text-decoration: underline;
        }
        .form-group .email-verified {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-group .email-verified i {
            color: #28a745;
        }
        .form-group .birth-date {
            display: flex;
            gap: 10px;
        }
        .form-group .birth-date select {
            flex: 1;
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
    <div class="container profile-container">
        <div class="profile-row">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-info">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/40?text=' . Auth::user()->name[0] }}" alt="User Avatar">
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <ul>
                    <li class="active">
                        <a href="{{ route('user.profile') }}"><i class="bi bi-person-fill"></i> Thông tin tài khoản</a>
                    </li>
                    <li>
                        <a href="{{ route('user.addresses') }}"><i class="bi bi-geo-alt-fill"></i> Sổ địa chỉ</a>
                    </li>
                    <li>
                        <a href=""><i class="bi bi-cart-fill"></i> Quản lý đơn hàng</a>
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
                <h2>Thông tin tài khoản</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="avatar">Ảnh đại diện</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                        @if (Auth::user()->avatar)
                            <div class="avatar-preview">
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Current Avatar">
                            </div>
                        @endif
                        @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Họ Tên</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="gender-options">
                            <div>
                                <input type="radio" id="male" name="gender" value="male" {{ Auth::user()->gender == 'male' ? 'checked' : '' }}>
                                <label for="male">Nam</label>
                            </div>
                            <div>
                                <input type="radio" id="female" name="gender" value="female" {{ Auth::user()->gender == 'female' ? 'checked' : '' }}>
                                <label for="female">Nữ</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <div class="phone-verification">
                            <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                            <a href="#">Xác thực</a>
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="email-verified">
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <div class="birth-date">
                            <select name="birth_day" required>
                                <option value="">Ngày</option>
                                @for ($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}" {{ Auth::user()->birth_date ? (Auth::user()->birth_date->day == $day ? 'selected' : '') : '' }}>
                                        {{ $day }}
                                    </option>
                                @endfor
                            </select>
                            <select name="birth_month" required>
                                <option value="">Tháng</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}" {{ Auth::user()->birth_date ? (Auth::user()->birth_date->month == $month ? 'selected' : '') : '' }}>
                                        {{ $month }}
                                    </option>
                                @endfor
                            </select>
                            <select name="birth_year" required>
                                <option value="">Năm</option>
                                @for ($year = date('Y'); $year >= 1900; $year--)
                                    <option value="{{ $year }}" {{ Auth::user()->birth_date ? (Auth::user()->birth_date->year == $year ? 'selected' : '') : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        @error('birth_day')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('birth_month')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('birth_year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="save-btn">LƯU THAY ĐỔI</button>
                </form>
            </div>
        </div>
    </div>
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <button id="backToTop" title="Go to top"><i class="bi bi-chevron-compact-up"></i></button>
    <script>
        window.onscroll = function() {
            const btn = document.getElementById("backToTop");
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                btn.style.display = "block";
            } else {
                btn.style.display = "none";
            }
        };

        document.getElementById("backToTop").addEventListener("click", function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>

