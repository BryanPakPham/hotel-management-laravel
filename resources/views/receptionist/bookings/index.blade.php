
@extends('layouts.receptionist')

@section('title', 'Quản lý đặt phòng')
@section('page-heading', 'Quản lý đặt phòng')
@section('breadcrumb', 'Trang chủ / Đặt phòng')

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
    .booking-summary-card {
        background: white;
        border: 1px solid #e7e9ed;
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
    }

    .booking-summary-label {
        color: #7a8491;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .booking-summary-value {
        color: #17324d;
        font-size: 26px;
        font-weight: 700;
    }

    .booking-summary-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f4efe4;
        color: #b49a65;
        border-radius: 10px;
        font-size: 21px;
    }

    .booking-data-card {
        margin-top: 25px;
        background: white;
        border: 1px solid #e7e9ed;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
    }

    .booking-data-header {
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        border-bottom: 1px solid #e7e9ed;
    }

    .booking-data-header h5 {
        font-size: 17px;
        font-weight: 700;
        color: #17324d;
        margin: 0;
    }

    .booking-record-count {
        color: #927640;
        background: #f7f2e8;
        border-radius: 20px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .booking-table {
        margin: 0;
        vertical-align: middle;
    }

    .booking-table thead th {
        background: #f8f9fb;
        color: #647084;
        font-size: 11px;
        letter-spacing: .4px;
        font-weight: 700;
        padding: 15px;
        white-space: nowrap;
        border-bottom: 1px solid #e7e9ed;
    }

    .booking-table tbody td {
        padding: 15px;
        font-size: 13px;
        white-space: nowrap;
        border-color: #eef0f3;
    }

    .booking-table tbody tr:hover td {
        background: #fcfaf5;
    }

    .booking-code {
        color: #17324d;
        font-weight: 700;
    }

    .booking-guest-name {
        color: #344054;
        font-weight: 600;
    }

    .booking-amount {
        color: #17324d;
        font-weight: 700;
    }

    .booking-status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        background: #f4efe4;
        color: #927640;
        font-size: 11px;
        font-weight: 700;
    }

    .booking-detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        background: #17324d;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        transition: .2s;
    }

    .booking-detail-btn:hover {
        background: #b49a65;
        color: white;
    }

    .booking-empty {
        text-align: center;
        padding: 45px 20px !important;
        color: #7a8491;
        white-space: normal !important;
    }

    .booking-empty i {
        display: block;
        font-size: 35px;
        color: #b49a65;
        margin-bottom: 10px;
    }

    .booking-pagination {
        padding: 20px 24px;
        overflow-x: auto;
    }

    .booking-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .booking-pagination .page-link {
        color: #17324d;
    }

    .booking-pagination .active .page-link {
        background: #17324d;
        border-color: #17324d;
        color: white;
    }

    @media (max-width: 576px) {
        .booking-data-header {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')

    {{-- Tiêu đề trang --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: #17324d;">
            Danh sách đặt phòng
        </h4>

        <p class="text-secondary mb-0">
            Theo dõi, kiểm tra và quản lý các lượt đặt phòng của khách hàng.
        </p>
    </div>

    {{-- Thống kê --}}
    <div class="row g-3">

        <div class="col-md-6 col-lg-4">
            <div class="booking-summary-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="booking-summary-label">
                            Số đơn trên trang hiện tại
                        </div>

                        <div class="booking-summary-value">
                            {{ $datPhong->count() }}
                        </div>
                    </div>

                    <div class="booking-summary-icon">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="booking-summary-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="booking-summary-label">
                            Tổng giá trị đơn trên trang
                        </div>

                        <div class="booking-summary-value" style="font-size: 20px;">
                            {{ number_format($datPhong->sum('total_amount'), 0, ',', '.') }}
                            <small style="font-size: 12px;">VNĐ</small>
                        </div>
                    </div>

                    <div class="booking-summary-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="booking-summary-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="booking-summary-label">
                            Nghiệp vụ
                        </div>

                        <div class="booking-summary-value" style="font-size: 19px;">
                            Đặt phòng
                        </div>
                    </div>

                    <div class="booking-summary-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Danh sách đặt phòng --}}
    <div class="booking-data-card">

        <div class="booking-data-header">
            <h5>
                <i class="bi bi-list-ul me-2" style="color: #b49a65;"></i>
                Danh sách lượt đặt phòng
            </h5>

            <span class="booking-record-count">
                {{ $datPhong->count() }} đơn trên trang
            </span>
        </div>

        <div class="table-responsive">
            <table class="table booking-table">

                <thead>
                    <tr>
                        <th>MÃ ĐẶT PHÒNG</th>
                        <th>KHÁCH HÀNG</th>
                        <th>SỐ ĐIỆN THOẠI</th>
                        <th>NGÀY NHẬN</th>
                        <th>NGÀY TRẢ</th>
                        <th>NGƯỜI LỚN</th>
                        <th>TRẺ EM</th>
                        <th>TRẠNG THÁI</th>
                        <th>TỔNG TIỀN</th>
                        <th>THAO TÁC</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($datPhong as $dat)
                        <tr>
                            <td>
                                <span class="booking-code">
                                    {{ $dat->booking_code }}
                                </span>
                            </td>

                            <td>
                                <span class="booking-guest-name">
                                    {{ $dat->guest_name }}
                                </span>
                            </td>

                            <td>{{ $dat->guest_phone }}</td>

                            <td>{{ $dat->check_in_date }}</td>

                            <td>{{ $dat->check_out_date }}</td>

                            <td class="text-center">
                                {{ $dat->num_adults }}
                            </td>

                            <td class="text-center">
                                {{ $dat->num_children }}
                            </td>

                            <td>
                                <span class="booking-status">
                                    {{ $dat->status }}
                                </span>
                            </td>

                            <td>
                                <span class="booking-amount">
                                    {{ number_format($dat->total_amount, 0, ',', '.') }} VNĐ
                                </span>
                            </td>

                            <td>
                                <div class="d-flex flex-column gap-2 align-items-start">

                                    <a href="{{ route('receptionist.bookings.show', $dat->id) }}"
                                       class="booking-detail-btn">
                                        <i class="bi bi-eye"></i>
                                        Chi tiết
                                    </a>

                                   @if ($dat->status == 'pending')
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('receptionist.bookings.confirm', $dat->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xác nhận đơn này?');">

                                                @csrf

                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Xác nhận
                                                </button>
                                            </form>

                                            <form action="{{ route('receptionist.bookings.cancel', $dat->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này không?');">

                                                @csrf

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Hủy
                                                </button>
                                            </form>
                                        </div>

                                    @elseif ($dat->status == 'confirmed')
                                        <div class="d-flex gap-2 align-items-center">
                                            <span class="badge text-bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Đã xác nhận
                                            </span>

                                            <form action="{{ route('receptionist.bookings.cancel', $dat->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này không?');">

                                                @csrf

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Hủy
                                                </button>
                                            </form>
                                        </div>

                                    @elseif ($dat->status == 'cancelled')
                                        <span class="badge text-bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Đã hủy
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="booking-empty">
                                <i class="bi bi-calendar-x"></i>

                                <strong class="d-block mb-2">
                                    Chưa có lượt đặt phòng nào
                                </strong>

                                <span>
                                    Khi có dữ liệu đặt phòng, danh sách sẽ hiển thị tại đây.
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Phân trang --}}
        @if (method_exists($datPhong, 'links'))
            <div class="booking-pagination">
                {{ $datPhong->links() }}
            </div>
        @endif

    </div>

@endsection
