
@extends('layouts.admin')

@section('title', 'Chi tiết đặt phòng')
@section('page-heading', 'Chi tiết đặt phòng')

@section('content')

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Đóng"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Đóng"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tiêu đề --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Chi tiết đặt phòng</h2>
            <p class="text-secondary mb-0">
                Thông tin đầy đủ về đơn đặt phòng của khách hàng.
            </p>
        </div>

        <a href="{{ route('admin.bookings.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Quay lại
        </a>
    </div>

    {{-- Thông tin đơn đặt phòng --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">Thông tin đơn đặt phòng</h5>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Mã đặt phòng
                    </div>
                    <div class="fw-bold">
                        {{ $booking->booking_code }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Trạng thái
                    </div>

                    @switch($booking->status)
                        @case('pending')
                            <span class="badge bg-warning-subtle text-warning-emphasis">
                                Chờ xác nhận
                            </span>
                            @break

                        @case('confirmed')
                            <span class="badge bg-success-subtle text-success">
                                Đã xác nhận
                            </span>
                            @break

                        @case('checked_in')
                            <span class="badge bg-primary-subtle text-primary">
                                Đang lưu trú
                            </span>
                            @break

                        @case('checked_out')
                            <span class="badge bg-secondary-subtle text-secondary">
                                Đã trả phòng
                            </span>
                            @break

                        @case('cancelled')
                            <span class="badge bg-danger-subtle text-danger">
                                Đã hủy
                            </span>
                            @break

                        @case('no_show')
                            <span class="badge bg-dark-subtle text-dark">
                                Không đến
                            </span>
                            @break

                        @default
                            <span class="badge bg-secondary">
                                {{ $booking->status }}
                            </span>
                    @endswitch

                    {{-- Nút xác nhận và hủy đặt phòng --}}
                    @if (in_array($booking->status, ['pending', 'confirmed'], true))
                        <div class="d-flex flex-wrap gap-2 mt-3">

                            @if ($booking->status === 'pending')
                                <form
                                    action="{{ route('admin.bookings.confirm', $booking->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xác nhận đơn đặt phòng này?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Xác nhận đặt phòng
                                    </button>
                                </form>
                            @endif

                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#cancelBookingForm">
                                <i class="bi bi-x-circle me-1"></i>
                                Hủy đặt phòng
                            </button>

                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Họ tên khách hàng
                    </div>
                    <div class="fw-semibold">
                        {{ $booking->guest_name }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Số điện thoại
                    </div>
                    <div>
                        {{ $booking->guest_phone }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Email
                    </div>
                    <div>
                        {{ $booking->guest_email ?: 'Chưa cung cấp' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Người lớn
                    </div>
                    <div>
                        {{ $booking->num_adults }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Trẻ em
                    </div>
                    <div>
                        {{ $booking->num_children }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Ngày đặt
                    </div>
                    <div>
                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Ngày nhận phòng
                    </div>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Ngày trả phòng
                    </div>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Tiền đặt cọc
                    </div>
                    <div>
                        {{ number_format($booking->deposit_amount, 0, ',', '.') }} đ
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">
                        Tổng tiền
                    </div>
                    <div class="fs-5 fw-bold" style="color: #12304A;">
                        {{ number_format($booking->total_amount, 0, ',', '.') }} đ
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-secondary small mb-1">
                        Ghi chú
                    </div>
                    <div>
                        {{ $booking->note ?: 'Không có ghi chú.' }}
                    </div>
                </div>

                @if ($booking->status === 'cancelled')
                    <div class="col-12">
                        <div class="text-secondary small mb-1">
                            Lý do hủy
                        </div>
                        <div>
                            {{ $booking->cancel_reason ?: 'Không có thông tin lý do hủy.' }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Form nhập lý do hủy --}}
    @if (in_array($booking->status, ['pending', 'confirmed'], true))
        <div class="collapse mb-4" id="cancelBookingForm">
            <div class="card border-danger shadow-sm rounded-3">
                <div class="card-body p-4">

                    <h5 class="fw-bold text-danger mb-3">
                        Hủy đơn đặt phòng
                    </h5>

                    <p class="text-secondary">
                        Vui lòng nhập lý do hủy trước khi xác nhận.
                    </p>

                    <form
                        action="{{ route('admin.bookings.cancel', $booking->id) }}"
                        method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này?')">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">
                                Lý do hủy <span class="text-danger">*</span>
                            </label>

                            <textarea
                                name="cancel_reason"
                                id="cancel_reason"
                                class="form-control @error('cancel_reason') is-invalid @enderror"
                                rows="3"
                                maxlength="1000"
                                required
                                placeholder="Nhập lý do hủy đặt phòng...">{{ old('cancel_reason') }}</textarea>

                            @error('cancel_reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-1"></i>
                            Xác nhận hủy
                        </button>
                    </form>

                </div>
            </div>
        </div>
    @endif

    {{-- Danh sách phòng trong đơn --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">Danh sách phòng đã đặt</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Loại phòng</th>
                            <th>Số phòng</th>
                            <th>Giá mỗi đêm</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookingRooms as $bookingRoom)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $bookingRoom->room_type_name ?: 'Không xác định' }}
                                </td>

                                <td>
                                    {{ $bookingRoom->room_number ?: 'Chưa phân phòng' }}
                                </td>

                                <td class="text-nowrap">
                                    {{ number_format($bookingRoom->price_per_night, 0, ',', '.') }} đ
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="text-center text-secondary py-4">
                                    Đơn đặt phòng chưa có thông tin phòng.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection
