<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng (Admin) - TTG Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #007bff; }
        .navbar { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .order-table { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    @extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4">Danh sách đơn hàng</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($orders->isEmpty())
            <p class="text-center text-muted">Không có đơn hàng nào.</p>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user?->name ?? 'Khách vãng lai' }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                    <td>
                                        <span class="badge {{ $order->status == 'delivered' ? 'bg-success' : ($order->status == 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>