@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Liên hệ với chúng tôi</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua:</p>
                <ul>
                    <li><strong>Email:</strong> support@ttgshop.vn</li>
                    <li><strong>Điện thoại:</strong> 0123 456 789</li>
                    <li><strong>Địa chỉ:</strong> Quốc Oai, Hà Nội, Việt Nam</li>
                </ul>
                <p>Hoặc theo dõi chúng tôi trên các nền tảng mạng xã hội:</p>
                <div>
                    <a href="https://facebook.com" target="_blank" class="text-primary me-2">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    <a href="https://twitter.com" target="_blank" class="text-primary me-2">
                        <i class="bi bi-twitter"></i> Twitter
                    </a>
                    <a href="https://instagram.com" target="_blank" class="text-primary me-2">
                        <i class="bi bi-instagram"></i> Instagram
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="text-primary">
                        <i class="bi bi-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection