<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTG Shop - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for social media icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        /* Updated Header Styles */
        .navbar {
            background: linear-gradient(90deg, #1a1a1a 0%, #333333 100%); /* Dark gradient background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            padding: 15px 0; /* Increased padding for better spacing */
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff !important;
            letter-spacing: 1px;
            transition: color 0.3s;
        }
        .navbar-brand:hover {
            color: #cccccc !important;
        }
        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-size: 1.1rem;
            margin-left: 15px;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #cccccc !important;
        }
        .navbar-toggler {
            border-color: #ffffff;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        /* Search Bar Styles */
        .search-form {
            max-width: 300px;
            margin-left: 20px;
        }
        .search-form .input-group {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .search-form .form-control {
            border: none;
            background-color: #ffffff;
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .search-form .btn {
            border: none;
            background-color: #ffffff;
            color: #1a1a1a;
            padding: 10px 15px;
        }
        .search-form .btn:hover {
            background-color: #f0f0f0;
        }
        footer {
            flex-shrink: 0;
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 40px 0;
            font-size: 14px;
        }
        footer h5 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #ffffff;
        }
        footer ul li {
            margin-bottom: 10px;
        }
        footer ul li a {
            color: #cccccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        footer ul li a:hover {
            color: #ffffff;
        }
        footer .social-icons a {
            font-size: 20px;
            color: #cccccc;
            margin-right: 15px;
            transition: color 0.3s;
        }
        footer .social-icons a:hover {
            color: #ffffff;
        }
        footer .contact-info i {
            margin-right: 8px;
            color: #cccccc;
        }
        footer hr {
            border-color: #333333;
        }
        footer .copyright {
            font-size: 13px;
            color: #999999;
        }
        
        .dropdown-menu {
            padding: 20px;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .dropdown-menu form {
            margin-bottom: 0;
        }
        .dropdown-menu .form-label {
            font-size: 0.9rem;
            color: #333;
        }
        .dropdown-menu .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            transition: border-color 0.2s;
        }
        .dropdown-menu .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .dropdown-menu .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            font-weight: 500;
            width: 100%;
        }
        .dropdown-menu .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        .dropdown-menu .text-muted {
            font-size: 0.8rem;
        }
        .dropdown-menu .text-muted a {
            text-decoration: none;
            color: #6c757d;
        }
        .dropdown-menu .text-muted a:hover {
            text-decoration: underline;
        }
        .dropdown-menu hr {
            margin: 1rem 0;
            border-top: 1px solid #dee2e6;
        }
        .dropdown-menu .text-center a {
            color: #007bff;
            text-decoration: none;
        }
        .dropdown-menu .text-center a:hover {
            text-decoration: underline;
        }

    .cart-dropdown {
        min-width: 320px;
        padding: 0;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .cart-item-row {
        transition: background-color 0.2s;
    }
    .cart-item-row:hover {
        background-color: #f8f9fa;
    }

    .cart-item-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 1px solid #eee;
    }

    .cart-item {
        padding: 8px 12px;
    }

    .cart-total {
        padding: 10px 12px;
        background-color: #f1f3f5;
        border-top: 1px solid #eee;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    </style>
</head>
<body> 
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">TTG Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Add Search Form -->
                <form class="search-form d-flex" action="{{ route('products.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Tìm kiếm sản phẩm..." required>
                        <button type="submit" class="btn"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav ms-auto">
                    @guest  
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-cart-fill"></i> Giỏ hàng 
                            (@php $cart = session()->get('cart', []); echo count($cart); @endphp)
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end cart-dropdown" aria-labelledby="cartDropdown">
                            @if (count($cart) > 0)
                                @php $total = 0; @endphp
                                @foreach ($cart as $id => $item)
                                    <li class="cart-item-row">
                                        <div class="cart-item d-flex align-items-center p-2">
                                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/default.jpg') }}" 
                                                alt="{{ $item['name'] }}" 
                                                class="cart-item-img rounded"
                                                onerror="this.src='{{ asset('images/default.jpg') }}';">
                                            <div class="ms-2 flex-grow-1">
                                                <p class="mb-0 text-dark fw-semibold">{{ $item['name'] }}</p>
                                                <small class="text-muted">x{{ $item['quantity'] }} - {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</small>
                                            </div>
                                        </div>
                                    </li>
                                @php $total += $item['price'] * $item['quantity']; @endphp
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li class="p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-dark">Tổng:</span>
                                        <span class="fw-bold text-primary">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                </li>
                                <li class="p-2">
                                    <a href="{{ route('cart.index') }}" class="btn btn-primary w-100 rounded-pill">Xem giỏ hàng</a>
                                </li>
                            @else
                                <li class="p-3 text-center text-muted">Giỏ hàng trống</li>
                            @endif
                        </ul>
                    </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-box-arrow-in-right"></i> Đăng nhập/ Đăng ký
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <h5 class="text-center">ĐĂNG NHẬP TÀI KHOẢN</h5>
                                    <p class="text-center">Nhập email và mật khẩu của bạn:</p>
                                    <div class="mb-3">
                                        <label for="login-email" class="form-label">Email</label>
                                        <input type="email" name="email" id="login-email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="login-password" class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" id="login-password" class="form-control @error('password') is-invalid @enderror" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-warning text-dark">Đăng nhập</button>
                                </form>
                                <p class="text-center text-muted small mt-2">
                                    This site is protected by reCAPTCHA and the Google
                                    <a href="https://policies.google.com/privacy" target="_blank" rel="noreferrer">Privacy Policy</a> and
                                    <a href="https://policies.google.com/terms" target="_blank" rel="noreferrer">Terms of Service</a> apply.
                                </p>
                                <hr>
                                <p class="text-center mb-0">
                                    <p>Khách hàng mới?<a href="{{ route('register') }}"> Tạo tài khoản</a></p>
                                    <!-- <p>Quên mật khẩu?<a href="{{ route('password.request') }}"> Khôi phục mật khẩu</a></p> -->
                                </p>
                            </div>
                        </li>
                        
                    @else
                        @if (Auth::check())
                        @if (Auth::user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.products.index') }}"><i class="bi bi-gear"></i> Quản lý</a>
                            </li>
                        @elseif (Auth::user()->is_staff)
                        @php
                            $roles = Auth::user()->load('roles')->roles->pluck('slug')->toArray();
                            \Log::info('User roles: ' . json_encode($roles));
                        @endphp
                        @if (!empty($roles))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.' . str_replace('manage-', '', $roles[0]) . '.index') }}"><i class="bi bi-gear"></i> Quản lý</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="#">Không có vai trò</a>
                            </li>
                        @endif
                    @endif
                    @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-cart-fill"></i> Giỏ hàng 
                                (@php $cart = session()->get('cart', []); echo count($cart); @endphp)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end cart-dropdown" aria-labelledby="cartDropdown">
                                @if (count($cart) > 0)
                                    @php $total = 0; @endphp
                                    @foreach ($cart as $id => $item)
                                        <li class="cart-item-row">
                                            <div class="cart-item d-flex align-items-center p-2">
                                                <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/default.jpg') }}" 
                                                    alt="{{ $item['name'] }}" 
                                                    class="cart-item-img rounded"
                                                    onerror="this.src='{{ asset('images/default.jpg') }}';">
                                                <div class="ms-2 flex-grow-1">
                                                    <p class="mb-0 text-dark fw-semibold">{{ $item['name'] }}</p>
                                                    <small class="text-muted">x{{ $item['quantity'] }} - {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</small>
                                                </div>
                                            </div>
                                        </li>
                                    @php $total += $item['price'] * $item['quantity']; @endphp
                                    @endforeach
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-dark">Tổng:</span>
                                            <span class="fw-bold text-primary">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                                        </div>
                                    </li>
                                    <li class="p-2">
                                        <a href="{{ route('cart.index') }}" class="btn btn-primary w-100 rounded-pill">Xem giỏ hàng</a>
                                    </li>
                                @else
                                    <li class="p-3 text-center text-muted">Giỏ hàng trống</li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> Bạn
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                            <div class="px-3 py-2">
                                <h5><i class="bi bi-emoji-laughing-fill"></i> Xin Chào, {{ Auth::user()->name }}!</h5>
                                <hr style="border-top: 3px solid #000;">
                                <a href="{{route('user.profile')}}" class="dropdown-item"><i class="bi bi-person-vcard-fill"></i> Thông tin người dùng</a>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endguest   
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-md-3 mb-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled contact-info">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            CS1: 83-85 Thái Hà, Đống Đa, Hà Nội
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            CS2: 83A Cửu Long, Q10, TP.HCM
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            CS3: Quốc Oai, Hà Nội
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            Hotline: 0356 042 005
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            Tư vấn Build PC: 0986552233
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            Email: support@ttgshop.vn
                        </li>
                    </ul>
                </div>
                <!-- Quick Links -->
                <div class="col-md-3 mb-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li><a href="{{ url('/about') }}">Về chúng tôi</a></li>
                        <li><a href="{{ url('/contact') }}">Liên hệ</a></li>
                    </ul>
                </div>
                <!-- About Section -->
                <div class="col-md-3 mb-4">
                    <h5>Về TTG Shop</h5>
                    <p>TTG Shop chuyên cung cấp PC cao cấp, phụ kiện game thủ, và dịch vụ tư vấn build PC. Chúng tôi cam kết mang đến sản phẩm chất lượng và dịch vụ tốt nhất.</p>
                </div>
                <!-- Social Media -->
                <div class="col-md-3 mb-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <div class="social-icons">
                        <a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://youtube.com" target="_blank"><i class="bi bi-youtube"></i></a>
                        <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center copyright">
                <p>© {{ date('Y') }} TTG Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle Login Form Submission
        $('#authDropdown + .dropdown-menu form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(response) {
                    // On success, reload the page to update the navbar
                    location.reload();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');

                    if (errors) {
                        $.each(errors, function(key, value) {
                            var field = form.find('[name="' + key + '"]');
                            field.addClass('is-invalid');
                            field.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    }
                }
            });
        });
    });
</script>
</body>
</html>