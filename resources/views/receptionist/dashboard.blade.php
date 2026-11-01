
@extends('layouts.receptionist')

@section('title', 'Dashboard Lễ tân')
@section('page-heading', 'Tổng quan')
@section('breadcrumb', 'Trang chủ / Lễ tân / Tổng quan')

@section('sidebar')

    <a href="{{ route('receptionist.dashboard') }}"
       class="receptionist-menu-link active">
        <i class="bi bi-grid"></i>
        <span>Tổng quan</span>
    </a>

    <a href="{{ route('receptionist.bookings.index') }}"
       class="receptionist-menu-link">
        <i class="bi bi-calendar-check"></i>
        <span>Quản lý đặt phòng</span>
    </a>

    <a href="{{ route('receptionist.stays.index') }}"
       class="receptionist-menu-link">
        <i class="bi bi-door-open"></i>
        <span>Quản lý lưu trú</span>
    </a>

    <a href="{{ route('receptionist.services.index') }}"
       class="receptionist-menu-link">
        <i class="bi bi-bell"></i>
        <span>Quản lý dịch vụ</span>
    </a>

    <a href="{{ route('receptionist.invoices.index') }}"
       class="receptionist-menu-link">
        <i class="bi bi-receipt"></i>
        <span>Quản lý hóa đơn</span>
    </a>

@endsection

@section('content')

    {{-- BANNER CHÀO MỪNG --}}
    <section class="welcome-banner">

        <div class="welcome-text">
            <span class="welcome-label">RECEPTIONIST WORKSPACE</span>

            <h2>Chào mừng đến với hệ thống lễ tân!</h2>

            <p>
                Quản lý hoạt động đặt phòng, hỗ trợ khách lưu trú
                và theo dõi các nghiệp vụ tại khách sạn.
            </p>
        </div>

        <div class="welcome-icon">
            <i class="bi bi-buildings"></i>
        </div>

    </section>

    {{-- TIÊU ĐỀ --}}
    <div class="section-heading">
        <h4>Chức năng quản lý</h4>
        <p>Truy cập nhanh các nghiệp vụ dành cho nhân viên lễ tân.</p>
    </div>

    {{-- CÁC THẺ CHỨC NĂNG --}}
    <div class="function-grid">

        <a href="{{ route('receptionist.bookings.index') }}"
           class="function-card">

            <div class="function-icon booking-icon">
                <i class="bi bi-calendar-check"></i>
            </div>

            <h5>Quản lý đặt phòng</h5>

            <p>
                Tiếp nhận và theo dõi thông tin đặt phòng của khách hàng.
            </p>

            <span class="function-link">
                Truy cập <i class="bi bi-arrow-right"></i>
            </span>

        </a>

        <a href="{{ route('receptionist.stays.index') }}"
           class="function-card">

            <div class="function-icon stay-icon">
                <i class="bi bi-door-open"></i>
            </div>

            <h5>Quản lý lưu trú</h5>

            <p>
                Hỗ trợ nhận phòng, theo dõi lưu trú và trả phòng.
            </p>

            <span class="function-link">
                Truy cập <i class="bi bi-arrow-right"></i>
            </span>

        </a>

        <a href="{{ route('receptionist.services.index') }}"
           class="function-card">

            <div class="function-icon service-icon">
                <i class="bi bi-bell"></i>
            </div>

            <h5>Quản lý dịch vụ</h5>

            <p>
                Theo dõi và hỗ trợ các dịch vụ được cung cấp cho khách.
            </p>

            <span class="function-link">
                Truy cập <i class="bi bi-arrow-right"></i>
            </span>

        </a>

        <a href="{{ route('receptionist.invoices.index') }}"
           class="function-card">

            <div class="function-icon invoice-icon">
                <i class="bi bi-receipt"></i>
            </div>

            <h5>Quản lý hóa đơn</h5>

            <p>
                Theo dõi hóa đơn và hỗ trợ thanh toán cho khách hàng.
            </p>

            <span class="function-link">
                Truy cập <i class="bi bi-arrow-right"></i>
            </span>

        </a>

    </div>

    {{-- QUY TRÌNH LÀM VIỆC --}}
    <section class="workflow-section">

        <div class="section-heading">
            <h4>Quy trình làm việc</h4>
            <p>Các nghiệp vụ thường dùng của nhân viên lễ tân.</p>
        </div>

        <div class="workflow-grid">

            <div class="workflow-item">
                <span class="workflow-number">01</span>

                <div>
                    <strong>Tiếp nhận đặt phòng</strong>
                    <p>Kiểm tra thông tin và xác nhận đặt phòng.</p>
                </div>
            </div>

            <div class="workflow-item">
                <span class="workflow-number">02</span>

                <div>
                    <strong>Thực hiện nhận phòng</strong>
                    <p>Hỗ trợ khách làm thủ tục nhận phòng.</p>
                </div>
            </div>

            <div class="workflow-item">
                <span class="workflow-number">03</span>

                <div>
                    <strong>Theo dõi lưu trú</strong>
                    <p>Hỗ trợ khách trong thời gian lưu trú tại khách sạn.</p>
                </div>
            </div>

            <div class="workflow-item">
                <span class="workflow-number">04</span>

                <div>
                    <strong>Thanh toán và trả phòng</strong>
                    <p>Kiểm tra hóa đơn và hoàn tất thủ tục trả phòng.</p>
                </div>
            </div>

        </div>

    </section>

@endsection
