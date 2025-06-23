<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Staff - TTG Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #ffffff;
            padding-top: 1rem;
        }
        .sidebar a {
            color: #adb5bd;
            padding: 0.5rem 1rem;
            display: block;
        }
        .sidebar a:hover {
            color: #ffffff;
            background-color: #495057;
        }
        .content {
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="text-center">Staff Panel</h4>
            <hr>
            @if (Auth::user()->hasRole('manage-banner'))
                <a href="{{ route('staff.banners.index') }}">Quản lý Banner</a>
            @endif
            @if (Auth::user()->hasRole('manage-products'))
                <a href="{{ route('staff.products.index') }}">Quản lý Sản phẩm</a>
            @endif
            @if (Auth::user()->hasRole('manage-orders'))
                <a href="{{ route('staff.orders.index') }}">Quản lý Đơn hàng</a>
            @endif
            @if (Auth::user()->hasRole('manage-categories'))
                <a href="{{ route('staff.categories.index') }}">Quản lý Danh mục</a>
            @endif
            @if (Auth::user()->hasRole('manage-users'))
                <a href="{{ route('staff.users.index') }}">Quản lý Người dùng</a>
            @endif
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <!-- Main Content -->
        <div class="content w-100">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>