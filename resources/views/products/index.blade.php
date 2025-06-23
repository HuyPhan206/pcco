<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTG Shop - Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .navbar-brand {
            font-weight: bold;
            color: #007bff;
        }
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
        .sidebar {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
        }
        .sidebar ul li a:hover {
            color: #007bff;
        }
        .sidebar .showroom {
            margin-top: 20px;
            color: #f39c12;
            font-size: 14px;
        }
        .sidebar .view-more {
            display: block;
            margin-top: 10px;
            color: #f39c12;
            text-decoration: none;
            font-weight: bold;
        }
        
        .banner-main {
            position: relative;
            background-size: cover;
            height: 400px;
            border-radius: 8px;
            color: #fff;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .banner-main h2 {
            font-size: 36px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .banner-small {
            position: relative;
            background-size: cover;
            height: 190px;
            border-radius: 8px;
            color: #fff;
            text-align: left;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .banner-small h5 {
            font-size: 18px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .banner-small p {
            font-size: 14px;
            margin: 0;
        }
        .banner-bottom {
            position: relative;
            background-size: cover;
            height: 150px;
            border-radius: 8px;
            color: #fff;
            text-align: left;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

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
        /* Tùy chỉnh dropdown submenu sang phải */
        
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
            display: none;
            position: absolute;
            border-radius: 0.25rem;
            min-width: 12rem;
        }

        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }


        
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <!-- Nội dung trang sản phẩm -->
    <div class="mt-5 ">
        <div class="container-fluid row">
            <!-- Sidebar Menu -->
            <div class="col-md-3">
                <div class="sidebar bg-secondary">
                    <ul class="navbar-nav me-auto">
                        <!-- Menu Đa Cấp -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Danh mục sản phẩm
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="categoryDropdown">
                                <!-- Cấp 1: PC Gaming -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'pc-gaming') }}">PC Gaming - Máy tính chơi game</a></li>
                                <!-- Cấp 1: PC Workstation -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'workstation') }}">PC Workstation</a></li>
                                <!-- Cấp 1: PC Văn Phòng -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'office-pc') }}">PC Văn Phòng</a></li>
                                <!-- Cấp 1: PC AMD Gaming -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'amd-gaming') }}">PC AMD Gaming</a></li>
                                <!-- Cấp 1: PC Core Ultra -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'core-ultra') }}">PC Core Ultra</a></li>
                                <!-- Cấp 1: PC Giá Lắp - Ào Hóa -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'cheap-build') }}">PC Giá Lắp - Ào Hóa</a></li>
                                <!-- Cấp 1: PC Mini -->
                                <li><a class="dropdown-item" href="{{ route('category.index', 'mini-pc') }}">PC Mini</a></li>                                
                                <!-- Cấp 1: Linh kiện máy tính -->
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Linh kiện máy tính</a>
                                    <ul class="dropdown-menu dropdown-menu-end sub-menu-horizontal">
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'power-supply') }}">Nguồn (PSU)</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'case') }}">Vỏ Case</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'storage') }}">SSD/HDD</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'cooling') }}">Tản nhiệt</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'cpu') }}">CPU</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'motherboard') }}">Mainboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'ram') }}">RAM</a></li>
                                        <li><a class="dropdown-item" href="{{ route('category.index', 'vga') }}">VGA Mới</a></li>
                                    </ul>
                                </li>
                                <!-- Cấp 1: Tùy Build Cấu Hình PC -->
                                <li><a class="category.index', 'custom-build') }}">Build Cấu Hình PC</a></li>
                            </ul>
                        </li>
                    </ul>
                    <a href="#" class="view-more">Chi tiết tại :</a>
                    <div class="showroom">
                        <p>Showroom 1: 83-85 Thái Hà, Đống Đa, Hà Nội</p>
                        <p>Showroom 2: 83A Cửu Long, Q10, TP.HCM</p>
                        <p>Showroom 3: Quốc Oai, Hà Nội</p>
                    </div>
                </div>
            </div>

            <!-- Banner Section and Products -->
            <div class="col-md-9">
                <!-- Banner Section -->
                <div class="row">
                    <!-- Main Banner -->
                    <div class="col-md-8">
                        @if ($mainBanner)
                            <div class="banner-main" style="background-image: url('{{ asset('storage/' . $mainBanner->image) }}')">
                            </div>
                        @else
                            <div class="banner-main">
                                <h2>Chưa có banner chính</h2>
                            </div>
                        @endif
                    </div>
                    <!-- Small Banner (Right) -->
                    <div class="col-md-4">
                        @if ($smallBanners->count() >= 1)
                            <div class="banner-small" style="background-image: url('{{ asset('storage/' . $smallBanners[0]->image) }}')">
                                @if ($smallBanners[0]->description)
                                    <p>{{ $smallBanners[0]->description }}</p>
                                @endif
                            </div>
                        @endif
                        @if ($smallBanners->count() >= 2)
                            <div class="banner-small mt-3" style="background-image: url('{{ asset('storage/' . $smallBanners[1]->image) }}')">
                                @if ($smallBanners[1]->description)
                                    <p>{{ $smallBanners[1]->description }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Bottom Banners -->
                <div class="row mt-3">
                    @for ($i = 2; $i < 6; $i++)
                        @if ($smallBanners->count() > $i)
                            <div class="col-md-4">
                                <div class="banner-bottom" style="background-image: url('{{ asset('storage/' . $smallBanners[$i]->image) }}')">
                                    @if ($smallBanners[$i]->description)
                                        <p>{{ $smallBanners[$i]->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>  
            </div>
        </div>
        <!-- Product List -->
        
                
        <div class="container mt-4">
            <h1 class="text-center mb-4">Sản phẩm nổi bật</h1>
            @if ($products->isEmpty())
                <div class="alert alert-info text-center">
                    Hiện tại chưa có sản phẩm nào!
                </div>
            @else
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;" >
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">
                                        @if ($product->discount_price && $product->discount_price < $product->price)
                                            <span class="text-decoration-line-through text-muted">
                                                {{ number_format($product->price, 0, ',', '.') }}đ
                                            </span>
                                            <span class="text-danger fw-bold ms-2">
                                                {{ number_format($product->discount_price, 0, ',', '.') }}đ
                                            </span>
                                        @else
                                            <span class="fw-bold">
                                                {{ number_format($product->price, 0, ',', '.') }}đ
                                            </span>
                                        @endif
                                    </p>

                                    <p class="card-text">Danh mục: {{ $product->category?->name ?? 'Không có danh mục' }}</p>
                                    <p class="card-text">Số lượng: {{ $product->stock }}</p>
                                    <a href="{{ route('products.show',$product->id) }}" class="btn btn-primary btn-sm mb-1">Xem</a>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            @endif 
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

