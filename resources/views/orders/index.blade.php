<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #007bff; }
        .navbar { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .order-table { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <!-- Danh sách đơn hàng -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Quản lý đơn hàng</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card order-table">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning">Đang xử lý</span>
                                    @elseif ($order->status == 'delivered')
                                        <span class="badge bg-success">Đã giao</span>
                                    @else
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm me-2">Chi tiết</a>
                                    @if ($order->status == 'pending')
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Hủy</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Bạn chưa có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>