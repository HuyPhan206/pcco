<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.products.index') }}">TTG Shop Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box"></i> Sản phẩm
                    </a>
                </li>                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.orders.*') || request()->routeIs('admin.revenue.*') ? 'active' : '' }}" href="#" id="orderDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-cart3"></i> Quản lý bán hàng
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="orderDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-cart3"></i> Đơn hàng
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}" href="{{ route('admin.revenue.index') }}">
                                <i class="bi bi-graph-up"></i> Báo cáo doanh thu
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i> Người dùng
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                        <i class="bi bi-image"></i> Banner
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}">
                        <i class="bi bi-person-badge"></i> Nhân viên
                    </a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="/" class="btn btn-outline-light me-2">
                    <i class="bi bi-house"></i> Về trang chủ
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
