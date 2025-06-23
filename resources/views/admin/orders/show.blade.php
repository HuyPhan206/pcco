<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng (Admin) - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #007bff; }
        .navbar { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .order-details { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    
    @extends('layouts.app')

@section('content')
    <div class="container py-5">
        @if (isset($error))
            <div class="text-center py-5">
                <h3 class="text-warning">{{ $error }}</h3>
                <p class="text-muted">Đơn hàng bạn tìm kiếm có thể đã bị xóa hoặc không tồn tại. Vui lòng kiểm tra lại.</p>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mt-3">Quay lại danh sách đơn hàng</a>
            </div>
        @elseif ($order)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Quản trị</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng #{{ $order->id }}</li>
                </ol>
            </nav>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <!-- Order Details -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="card-title text-primary mb-3">Chi tiết đơn hàng #{{ $order->id }}</h2>
                            <div class="mb-4">
                                <p><strong>Khách hàng:</strong> {{ $order->user?->name ?? 'Khách vãng lai' }}</p>
                                <p><strong>Email:</strong> {{ $order->user?->email ?? 'Không có' }}</p>
                                <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }}đ</p>
                                <p><strong>Trạng thái:</strong> 
                                    <span class="badge {{ $order->status == 'delivered' ? 'bg-success' : ($order->status == 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $order->status }}
                                    </span>
                                </p>
                                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>                            <h4 class="text-muted mb-3">Cập nhật trạng thái</h4>
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <select name="status" class="form-select" required>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="text-muted mb-3">Sản phẩm trong đơn hàng</h4>
                            @if ($order->items->isEmpty())
                                <p class="text-muted">Không có sản phẩm trong đơn hàng này.</p>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product?->name ?? 'Sản phẩm không tồn tại' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <h3 class="text-warning">Có lỗi xảy ra!</h3>
                <p class="text-muted">Không thể tải thông tin đơn hàng. Vui lòng thử lại hoặc quay lại trang chính.</p>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mt-3">Quay lại danh sách đơn hàng</a>
            </div>
        @endif
    </div>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>