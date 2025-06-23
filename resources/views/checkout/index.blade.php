@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1>Thông tin giao hàng và thanh toán</h1>

        @if (session('cart') && count(session('cart')) > 0)
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="shipping_name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control @error('shipping_name') is-invalid @enderror" id="shipping_name" name="shipping_name" value="{{ old('shipping_name') }}" required>
                            @error('shipping_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control @error('shipping_phone') is-invalid @enderror" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone') }}" required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
                                <option value="momo" {{ old('payment_method') == 'momo' ? 'selected' : '' }}>Thanh toán qua MoMo</option>
                                <option value="zalopay" {{ old('payment_method') == 'zalopay' ? 'selected' : '' }}>Thanh toán qua ZaloPay</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('cart')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Hoàn tất thanh toán</button>
                    </form>
                </div>

                <div class="col-md-4">
                    <h3>Giỏ hàng</h3>
                    @foreach ($cart as $item)
                        <p>{{ $item['name'] }} - {{ number_format($item['price'], 0, ',', '.') }}đ x {{ $item['quantity'] }}</p>
                    @endforeach
                    <p>Tổng: {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 0, ',', '.') }}đ</p>
                </div>
            </div>
        @else
            <p>Giỏ hàng trống.</p>
        @endif
    </div>
@endsection