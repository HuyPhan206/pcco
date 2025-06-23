<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Custom footer styles for admin */
        footer {
            background-color: #1a1a1a;
            color: #999999;
            padding: 20px 0;
            font-size: 13px;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            color: #fff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .brand {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar .brand a {
            color: #007bff;
            text-decoration: none;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar ul li a.active {
            background-color: #007bff;
            color: #fff;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        .content-table {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <a href="{{ url('/') }}">TTG Shop</a>
        </div>
        <ul>    
            <li>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Quản lý Sản phẩm
                </a>
            </li>
            <li>
                <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i> Quản lý Banner
                </a>
            </li>
          <li>
            <a href="{{ route('admin.revenue.index') }}" class="{{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Quản lý Doanh thu
            </a>
        </li>
             <li>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Quản lý Đơn Hàng
                </a>
            </li>
            <li>
                <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Quản lý Nhân Viên
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Quản lý Người Dùng
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-light w-100 text-start p-3" style="text-decoration: none;">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>
    footer class="text-center">
        <div class="container text-center">
            <p>© {{ date('Y') }} TTG Shop - Admin Panel. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>