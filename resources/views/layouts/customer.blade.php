<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Khám phá kỳ nghỉ | Vinpearl')</title>

    <meta name="description" content="Khám phá không gian nghỉ dưỡng và lựa chọn kỳ nghỉ phù hợp với bạn.">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS dùng chung cho Customer -->
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">

    @stack('styles')
</head>

<body>

    <!-- ================= HEADER ================= -->
    <header class="customer-header">
        <nav class="navbar navbar-expand-lg customer-navbar">
            <div class="container">

                <!-- Logo dạng text tạm thời -->
                <a class="navbar-brand brand" href="{{ url('/') }}">
                    <span class="brand__name">VINPEARL</span>
                    <span class="brand__subtitle">YOUR JOURNEY, YOUR STORY</span>
                </a>

                <!-- Menu hamburger trên điện thoại -->
                <button class="navbar-toggler customer-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#customerNavbar" aria-controls="customerNavbar" aria-expanded="false"
                    aria-label="Mở menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="customerNavbar">

                    <ul class="navbar-nav mx-auto customer-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                Trang chủ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rooms.index') }}">
                                Phòng nghỉ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#services">
                                Dịch vụ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('highlights') }}">
                                Điểm nổi bật
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#about">
                                Giới thiệu
                            </a>
                        </li>
                    </ul>

                    <div class="header-actions">
                        <a href="{{ auth()->check() ? route('customer.dashboard') : url('/login') }}"
                            title="Chức năng đang được phát triển">
                            <i class="bi bi-person me-1"></i>
                            Đăng nhập
                        </a>
                    </div>

                </div>
            </div>
        </nav>
    </header>


    <!-- ================= HERO ================= -->
    <section class="customer-hero">

        {{-- TODO: Bổ sung ảnh nền nghỉ dưỡng tại đây.
             Đặt ảnh trong public/assets/images/banners/
             và cập nhật background-image trong customer.css. --}}

        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <span class="hero-eyebrow">DISCOVER YOUR NEXT JOURNEY</span>

            <h1 class="hero-title">
                Khám phá kỳ nghỉ </br>

                <span>trong mơ của bạn</span>
            </h1>

            <p class="hero-description">
                Tận hưởng những khoảnh khắc đáng nhớ
                trong không gian nghỉ dưỡng tuyệt vời.
            </p>
        </div>

    </section>


    <!-- ================= SEARCH / BOOKING ================= -->
    <section class="booking-section">
        <div class="container">

            @hasSection('search')
                @yield('search')
            @else
                <form action="{{ route('rooms.index') }}" method="GET" class="booking-form" id="bookingSearchForm">

                    <div class="booking-field booking-destination">
                        <label for="destination">
                            <i class="bi bi-geo-alt"></i>
                            Điểm đến
                        </label>
                        <select name="destination" id="destination" class="form-select">
                            <option value="nha-trang">Vinpearl Nha Trang</option>
                            <option value="phu-quoc">Vinpearl Phú Quốc</option>
                            <option value="da-nang">Vinpearl Đà Nẵng</option>
                            <option value="nam-hoi-an">Vinpearl Nam Hội An</option>
                        </select>
                    </div>

                    <div class="booking-field">
                        <label for="checkin">
                            <i class="bi bi-calendar-check"></i>
                            Nhận phòng
                        </label>

                        <input type="date" name="checkin" id="checkin" class="form-control" required>
                    </div>

                    <div class="booking-field">
                        <label for="checkout">
                            <i class="bi bi-calendar2-check"></i>
                            Trả phòng
                        </label>

                        <input type="date" name="checkout" id="checkout" class="form-control" required>
                    </div>

                    <div class="booking-field booking-guests">
                        <label for="adults">
                            <i class="bi bi-people"></i>
                            Người lớn
                        </label>

                        <select name="adults" id="adults" class="form-select">
                            <option value="1">1 người</option>
                            <option value="2" selected>2 người</option>
                            <option value="3">3 người</option>
                            <option value="4">4 người</option>
                            <option value="5">5 người</option>
                            <option value="6">6 người</option>
                        </select>
                    </div>

                    <div class="booking-field booking-guests">
                        <label for="children">
                            <i class="bi bi-person-hearts"></i>
                            Trẻ em
                        </label>

                        <select name="children" id="children" class="form-select">
                            <option value="0" selected>0 trẻ em</option>
                            <option value="1">1 trẻ em</option>
                            <option value="2">2 trẻ em</option>
                            <option value="3">3 trẻ em</option>
                            <option value="4">4 trẻ em</option>
                        </select>
                    </div>

                    <div class="booking-field booking-guests">
                        <label for="rooms">
                            <i class="bi bi-door-open"></i>
                            Số phòng
                        </label>

                        <select name="rooms" id="rooms" class="form-select">
                            <option value="1" selected>1 phòng</option>
                            <option value="2">2 phòng</option>
                            <option value="3">3 phòng</option>
                            <option value="4">4 phòng</option>
                        </select>
                    </div>

                    <div class="booking-submit">
                        <button type="submit" class="btn btn-search">
                            <i class="bi bi-search me-2"></i>
                            Tìm phòng
                        </button>
                    </div>

                    <p class="booking-message" id="bookingMessage" role="alert" aria-live="polite"></p>

                </form>
            @endif

        </div>
    </section>


    <!-- ================= MAIN CONTENT ================= -->
    <main class="customer-main">
        @yield('content')
    </main>


    <!-- ================= HOTEL VIDEO GALLERY ================= -->
    <section class="hotel-video-section">
        <div class="container-fluid px-0">

            <div class="video-heading container">
                <span class="section-eyebrow">THE ART OF ESCAPE</span>

                <h2>Khám phá kỳ nghỉ của bạn</h2>

                <p>
                    Cảm hứng cho những hành trình thư giãn,
                    khám phá và tận hưởng từng khoảnh khắc.
                </p>
            </div>

            <div class="video-gallery" id="hotelVideoGallery">

                <!-- Video 1 -->
                <div class="video-slide is-active" data-video-index="0">

                    <video class="hotel-video" controls playsinline autoplay loop muted preload="metadata">
                        <source src="{{ asset('assets/videos/introduce.mp4') }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>

                    <div class="video-placeholder">
                        <i class="bi bi-play-circle"></i>
                        <h3>Không gian nghỉ dưỡng</h3>
                        <p>Vui lòng bổ sung video giới thiệu thứ nhất.</p>
                    </div>
                </div>

                <!-- Video 2 -->
                <div class="video-slide" data-video-index="1" hidden>

                    <video class="hotel-video" controls playsinline autoplay loop muted preload="metadata">
                        <source src="{{ asset('assets/videos/introduce2.mp4') }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>

                    <div class="video-placeholder">
                        <i class="bi bi-play-circle"></i>
                        <h3>Trải nghiệm đáng nhớ</h3>
                        <p>Vui lòng bổ sung video giới thiệu thứ hai.</p>
                    </div>
                </div>

                <!-- Video 3 -->
                <div class="video-slide" data-video-index="2" hidden>

                    <video class="hotel-video" controls autoplay loop muted playsinline preload="metadata">
                        <source src="{{ asset('assets/videos/introduce3.mp4') }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>

                    <div class="video-placeholder">
                        <i class="bi bi-play-circle"></i>
                        <h3>Tiện ích và dịch vụ</h3>
                        <p>Vui lòng bổ sung video giới thiệu thứ ba.</p>
                    </div>
                </div>

                <!-- Nút điều hướng -->
                <button type="button" class="video-control video-control--prev" id="videoPrev"
                    aria-label="Video trước">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button type="button" class="video-control video-control--next" id="videoNext"
                    aria-label="Video tiếp theo">
                    <i class="bi bi-chevron-right"></i>
                </button>

                <div class="video-indicators" id="videoIndicators" aria-label="Chọn video">
                    <button type="button" class="video-dot is-active" data-video-target="0" aria-label="Video 1"
                        aria-current="true"></button>

                    <button type="button" class="video-dot" data-video-target="1" aria-label="Video 2"></button>

                    <button type="button" class="video-dot" data-video-target="2" aria-label="Video 3"></button>
                </div>

            </div>
        </div>
    </section>


    <!-- ================= FOOTER ================= -->
    <footer class="customer-footer">
        <div class="container">

            <div class="row g-4 footer-main">

                <!-- Thương hiệu -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/') }}" class="brand footer-brand">
                        <span class="brand__name">VINPEARL</span>
                        <span class="brand__subtitle">
                            YOUR JOURNEY, YOUR STORY
                        </span>
                    </a>

                    <p class="footer-description">
                        Khám phá những điểm đến tuyệt đẹp,
                        tận hưởng dịch vụ nghỉ dưỡng và lưu giữ
                        những khoảnh khắc đáng nhớ.
                    </p>

                    <p class="footer-note">
                        Website đồ án minh họa, không phải website chính thức
                        của Vinpearl.
                    </p>
                </div>

                <!-- Khám phá -->
                <div class="col-lg-2 col-md-6">
                    <h3 class="footer-title">Khám phá</h3>

                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Trang chủ</a></li>
                        <li><a href="#rooms">Phòng nghỉ</a></li>
                        <li><a href="#services">Dịch vụ</a></li>
                        <li><a href="{{ route('highlights') }}">Điểm nổi bật</a></li>
                        <li><a href="#about">Giới thiệu</a></li>
                    </ul>
                </div>

                <!-- Hỗ trợ -->
                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">Hỗ trợ khách hàng</h3>

                    <ul class="footer-links">
                        <!-- TODO: Thay # bằng route thật khi có trang -->
                        <li><a href="#faq">Câu hỏi thường gặp</a></li>
                        <li><a href="#booking-guide">Hướng dẫn đặt phòng</a></li>
                        <li><a href="#booking-policy">Chính sách đặt phòng</a></li>
                        <li><a href="#cancellation">Chính sách hủy phòng</a></li>
                    </ul>
                </div>

                <!-- Liên hệ -->
                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">Liên hệ</h3>

                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <span>Địa chỉ: Chưa cập nhật</span>
                        </li>

                        <li>
                            <i class="bi bi-envelope"></i>
                            <span>Email: Chưa cập nhật</span>
                        </li>

                        <li>
                            <i class="bi bi-telephone"></i>
                            <span>Điện thoại: Chưa cập nhật</span>
                        </li>
                    </ul>

                    <div class="footer-social">
                        <!-- TODO: Bổ sung liên kết mạng xã hội thật -->
                        <a href="#facebook" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="#instagram" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="#youtube" aria-label="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p>
                    &copy; {{ date('Y') }} Website đặt phòng khách sạn.
                    Giao diện đồ án học tập.
                </p>

                <div class="footer-bottom-links">
                    <a href="#privacy">Quyền riêng tư</a>
                    <a href="#terms">Điều khoản sử dụng</a>
                </div>
            </div>

        </div>
    </footer>


    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript dùng chung -->
    <script src="{{ asset('js/customer.js') }}"></script>

    @stack('scripts')

</body>

</html>
