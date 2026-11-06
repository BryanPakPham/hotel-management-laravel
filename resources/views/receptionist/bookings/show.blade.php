
@extends('layouts.receptionist')

@section('title', 'Chi tiết đặt phòng')
@section('page-heading', 'Chi tiết đặt phòng')
@section('breadcrumb', 'Trang chủ / Đặt phòng / Chi tiết')

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

@push('styles')
<style>
    .booking-detail-card {
        background: white;
        border: 1px solid #e7e9ed;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(23, 50, 77, .04);
    }

    .booking-detail-header {
        padding: 25px 28px;
        background: #17324d;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .booking-detail-header h5 {
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .booking-detail-code {
        font-size: 13px;
        color: #d6c49b;
    }

    .booking-detail-status {
        display: inline-block;
        background: #f4efe4;
        color: #80652e;
        border-radius: 20px;
        padding: 8px 13px;
        font-size: 12px;
        font-weight: 700;
    }

    .booking-detail-body {
        padding: 28px;
    }

    .booking-section-title {
        color: #17324d;
        font-size: 16px;
        font-weight: 700;
        padding-bottom: 15px;
        margin-bottom: 8px;
        border-bottom: 1px solid #e7e9ed;
    }

    .booking-section-title i {
        color: #b49a65;
        margin-right: 8px;
    }

    .booking-info-row {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        padding: 15px 0;
        border-bottom: 1px solid #eef0f3;
    }

    .booking-info-label {
        color: #7a8491;
        font-size: 13px;
    }

    .booking-info-value {
        color: #344054;
        font-size: 13px;
        font-weight: 600;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .booking-price-box {
        margin-top: 28px;
        padding: 22px;
        border: 1px solid #e9e0ce;
        background: #f8f5ed;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .booking-price-label {
        color: #667085;
        font-size: 13px;
    }

    .booking-price-value {
        color: #927640;
        font-size: 25px;
        font-weight: 800;
        text-align: right;
    }

    .booking-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid #17324d;
        border-radius: 6px;
        background: #17324d;
        color: white;
        text-decoration: none;
        font-size: 13px;
        transition: .2s;
    }

    .booking-back-btn:hover {
        background: #b49a65;
        border-color: #b49a65;
        color: white;
    }

    .booking-internal-note {
        color: #8a929e;
        font-size: 12px;
        margin-top: 20px;
        margin-bottom: 0;
    }

    @media (max-width: 576px) {
        .booking-detail-header,
        .booking-detail-body {
            padding: 20px;
        }

        .booking-price-box {
            align-items: flex-start;
            flex-direction: column;
        }

        .booking-price-value {
            text-align: left;
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')

    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: #17324d;">
            Chi tiết đặt phòng
        </h4>

        <p class="text-secondary mb-0">
            Kiểm tra thông tin khách hàng và lịch trình để phục vụ công tác lễ tân.
        </p>
    </div>

    <div class="booking-detail-card">

        {{-- Header thông tin đơn --}}
        <div class="booking-detail-header">
            <div>
                <h5>
                    <i class="bi bi-calendar2-check me-2"></i>
                    Thông tin lượt đặt phòng
                </h5>

                <div class="booking-detail-code">
                    Mã đặt phòng: {{ $dat->booking_code }}
                </div>
            </div>

            <span class="booking-detail-status">
                {{ $dat->status }}
            </span>
        </div>

        <div class="booking-detail-body">

            <div class="row g-4">

                {{-- Thông tin khách hàng --}}
                <div class="col-lg-6">
                    <h6 class="booking-section-title">
                        <i class="bi bi-person-vcard"></i>
                        Thông tin khách hàng
                    </h6>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Họ và tên</span>
                        <span class="booking-info-value">
                            {{ $dat->guest_name }}
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Số điện thoại</span>
                        <span class="booking-info-value">
                            {{ $dat->guest_phone }}
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Tài khoản đặt phòng</span>
                        <span class="booking-info-value">
                            {{ $dat->tenTaiKhoan ?? 'Khách vãng lai' }}
                        </span>
                    </div>
                </div>

                {{-- Thông tin lưu trú --}}
                <div class="col-lg-6">
                    <h6 class="booking-section-title">
                        <i class="bi bi-calendar-week"></i>
                        Thông tin lưu trú
                    </h6>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Ngày nhận phòng</span>
                        <span class="booking-info-value">
                            {{ $dat->check_in_date }}
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Ngày trả phòng</span>
                        <span class="booking-info-value">
                            {{ $dat->check_out_date }}
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Số người lớn</span>
                        <span class="booking-info-value">
                            {{ $dat->num_adults }} người
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Số trẻ em</span>
                        <span class="booking-info-value">
                            {{ $dat->num_children }} trẻ
                        </span>
                    </div>

                    <div class="booking-info-row">
                        <span class="booking-info-label">Trạng thái hiện tại</span>
                        <span class="booking-info-value">
                            {{ $dat->status }}
                        </span>
                    </div>
                </div>

            </div>

            {{-- Tổng tiền --}}
            <div class="booking-price-box">
                <div>
                    <div class="booking-price-label">
                        <i class="bi bi-wallet2 me-2"></i>
                        Tổng giá trị đơn đặt phòng
                    </div>

                    <small class="text-secondary">
                        Theo dữ liệu hiện tại trong hệ thống
                    </small>
                </div>

                <div class="booking-price-value">
                    {{ number_format($dat->total_amount, 0, ',', '.') }} VNĐ
                </div>
            </div>

            {{-- Nút quay lại --}}
            <div class="mt-4">
                <a href="{{ route('receptionist.bookings.index') }}"
                   class="booking-back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại danh sách
                </a>
            </div>

            <p class="booking-internal-note">
                Giao diện quản lý nội bộ dành cho nhân viên lễ tân.
            </p>

        </div>
    </div>

@endsection
