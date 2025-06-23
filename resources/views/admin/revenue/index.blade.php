@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">Báo Cáo Doanh Thu</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.revenue.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="period" class="form-label">Thời gian</label>
                    <select name="period" id="period" class="form-select">
                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Tuần này</option>
                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Tháng này</option>
                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Năm nay</option>
                        <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                    </select>
                </div>
                
                <div class="col-md-3 custom-dates {{ $period == 'custom' ? '' : 'd-none' }}">
                    <label for="start_date" class="form-label">Từ ngày</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
                </div>
                
                <div class="col-md-3 custom-dates {{ $period == 'custom' ? '' : 'd-none' }}">
                    <label for="end_date" class="form-label">Đến ngày</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
                </div>
                
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Xem báo cáo</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Tổng doanh thu</h5>
                    <h2 class="display-5 text-primary">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h2>
                    <p class="text-muted">Từ {{ $startDate->format('d/m/Y') }} đến {{ $endDate->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Doanh thu theo ngày</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Top sản phẩm có doanh thu cao</h5>
                </div>
                <div class="card-body">
                    <canvas id="productChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Chi tiết theo sản phẩm</h5>
                    <button class="btn btn-sm btn-outline-secondary" id="btnExport">Xuất Excel</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productRevenues as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->units_sold }}</td>
                                    <td>{{ number_format($product->revenue, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle custom date inputs
    document.getElementById('period').addEventListener('change', function() {
        const customDates = document.querySelectorAll('.custom-dates');
        if (this.value === 'custom') {
            customDates.forEach(el => el.classList.remove('d-none'));
        } else {
            customDates.forEach(el => el.classList.add('d-none'));
        }
    });

    // Daily Revenue Chart
    const revenueChartCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueChartCtx, {
        type: 'bar',
        data: {
            labels: {!! $chartLabels !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! $chartData !!},
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + parseInt(context.raw).toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            }
        }
    });

    // Products Revenue Chart
    const productChartCtx = document.getElementById('productChart').getContext('2d');
    new Chart(productChartCtx, {
        type: 'bar',
        data: {
            labels: {!! $productLabels !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! $productData !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(199, 199, 199, 0.5)',
                    'rgba(83, 102, 255, 0.5)',
                    'rgba(40, 159, 64, 0.5)',
                    'rgba(210, 199, 199, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(40, 159, 64, 1)',
                    'rgba(210, 199, 199, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + parseInt(context.raw).toLocaleString('vi-VN') + 'đ';
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection
