
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-heading', 'Dashboard tổng quan')

@section('content')

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Tổng quan khách sạn</h3>
        <p class="text-secondary mb-0">
            Theo dõi tình hình phòng và hoạt động đặt phòng.
        </p>
    </div>

    {{-- Thống kê phòng --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">Tổng số phòng</div>
                    <h2 class="fw-bold">{{ $totalRooms }}</h2>
                    <div class="small text-secondary">Toàn bộ phòng khách sạn</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">Phòng trống</div>
                    <h2 class="fw-bold text-success">{{ $availableRooms }}</h2>
                    <div class="small text-secondary">Trạng thái available</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">Phòng đang sử dụng</div>
                    <h2 class="fw-bold text-danger">{{ $occupiedRooms }}</h2>
                    <div class="small text-secondary">Trạng thái occupied</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">Dọn dẹp / Bảo trì</div>
                    <h2 class="fw-bold text-warning">{{ $maintenanceRooms }}</h2>
                    <div class="small text-secondary">Chưa sẵn sàng phục vụ</div>
                </div>
            </div>
        </div>

    </div>

    {{-- Thống kê đặt phòng và khách hàng --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary mb-2">Tổng đơn đặt phòng</div>
                    <h3 class="fw-bold">{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary mb-2">Đơn chờ xác nhận</div>
                    <h3 class="fw-bold text-warning">{{ $pendingBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary mb-2">Tổng khách hàng</div>
                    <h3 class="fw-bold">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Đặt phòng gần đây --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Đặt phòng gần đây</h5>
                <span class="text-secondary small">5 đơn mới nhất</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Mã đặt phòng</th>
                            <th>Khách hàng</th>
                            <th>Ngày nhận</th>
                            <th>Ngày trả</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recentBookings as $booking)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $booking->booking_code }}
                                </td>

                                <td>
                                    <div>{{ $booking->guest_name }}</div>
                                    <small class="text-secondary">
                                        {{ $booking->guest_phone }}
                                    </small>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ number_format($booking->total_amount, 0, ',', '.') }} đ
                                </td>

                                <td>
                                    @if ($booking->status == 'pending')
                                        <span class="badge text-bg-warning">Chờ xác nhận</span>
                                    @elseif ($booking->status == 'confirmed')
                                        <span class="badge text-bg-primary">Đã xác nhận</span>
                                    @elseif ($booking->status == 'checked_in')
                                        <span class="badge text-bg-success">Đang lưu trú</span>
                                    @elseif ($booking->status == 'checked_out')
                                        <span class="badge text-bg-secondary">Đã trả phòng</span>
                                    @elseif ($booking->status == 'cancelled')
                                        <span class="badge text-bg-danger">Đã hủy</span>
                                    @else
                                        <span class="badge text-bg-dark">Không đến</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">
                                    Chưa có đơn đặt phòng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
