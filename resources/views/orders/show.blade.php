<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng - TTG Shop</title>
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
    <!-- Chi tiết đơn hàng -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Chi tiết đơn hàng #{{ $order->order_number }}</h2>
        <div class="card order-details">
            <div class="card-body">
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }} VNĐ</p>
                <p><strong>Trạng thái:</strong>
                    @if ($order->status == 'pending')
                        <span class="badge bg-warning">Đang xử lý</span>
                    @elseif ($order->status == 'delivered')
                        <span class="badge bg-success">Đã giao</span>
                    @else
                        <span class="badge bg-danger">Đã hủy</span>
                    @endif
                </p>
                <h5 class="mt-4">Sản phẩm trong đơn hàng</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Không có sản phẩm trong đơn hàng.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>