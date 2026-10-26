
@extends('layouts.admin')

@section('title', 'Quản lý đặt phòng')
@section('page-heading', 'Quản lý đặt phòng')

@section('content')

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- Tiêu đề --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Quản lý đặt phòng</h2>
        <p class="text-secondary mb-0">
            Theo dõi và tra cứu các đơn đặt phòng của khách hàng.
        </p>
    </div>

    {{-- Thống kê --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Tổng đơn đặt phòng</div>
                <div class="fs-3 fw-bold" style="color: #12304A;">
                    {{ $totalBookings }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Chờ xác nhận</div>
                <div class="fs-3 fw-bold text-warning">
                    {{ $pendingBookings }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Đã xác nhận</div>
                <div class="fs-3 fw-bold text-success">
                    {{ $confirmedBookings }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Đang lưu trú</div>
                <div class="fs-3 fw-bold text-primary">
                    {{ $checkedInBookings }}
                </div>
            </div>
        </div>

    </div>

    {{-- Tìm kiếm và lọc --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">

            <form action="{{ route('admin.bookings.index') }}"
                  method="GET"
                  class="row g-3">

                <div class="col-lg-4 col-md-6">
                    <label for="keyword" class="form-label">
                        Tìm kiếm
                    </label>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        class="form-control"
                        placeholder="Mã đặt phòng, tên hoặc SĐT..."
                        value="{{ request('keyword') }}"
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label for="status" class="form-label">
                        Trạng thái
                    </label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending"
                            @selected(request('status') == 'pending')>
                            Chờ xác nhận
                        </option>
                        <option value="confirmed"
                            @selected(request('status') == 'confirmed')>
                            Đã xác nhận
                        </option>
                        <option value="checked_in"
                            @selected(request('status') == 'checked_in')>
                            Đang lưu trú
                        </option>
                        <option value="checked_out"
                            @selected(request('status') == 'checked_out')>
                            Đã trả phòng
                        </option>
                        <option value="cancelled"
                            @selected(request('status') == 'cancelled')>
                            Đã hủy
                        </option>
                        <option value="no_show"
                            @selected(request('status') == 'no_show')>
                            Không đến
                        </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="check_in_date" class="form-label">
                        Nhận phòng từ
                    </label>
                    <input
                        type="date"
                        id="check_in_date"
                        name="check_in_date"
                        class="form-control"
                        value="{{ request('check_in_date') }}"
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label for="check_in_date_to" class="form-label">
                        Nhận phòng đến
                    </label>
                    <input
                        type="date"
                        id="check_in_date_to"
                        name="check_in_date_to"
                        class="form-control"
                        value="{{ request('check_in_date_to') }}"
                    >
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Tìm kiếm
                    </button>

                    <a href="{{ route('admin.bookings.index') }}"
                       class="btn btn-outline-secondary">
                        Làm mới
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Danh sách đặt phòng --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Danh sách đặt phòng</h5>
                <span class="text-secondary small">
                    {{ $bookings->total() }} đơn
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Mã đặt phòng</th>
                            <th>Khách hàng</th>
                            <th>Ngày nhận</th>
                            <th>Ngày trả</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>
                                    {{ $bookings->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-bold">
                                    {{ $booking->booking_code }}
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $booking->guest_name }}
                                    </div>
                                    <div class="text-secondary small">
                                        {{ $booking->guest_phone }}
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                </td>

                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                                </td>

                                <td class="text-nowrap fw-semibold">
                                    {{ number_format($booking->total_amount, 0, ',', '.') }} đ
                                </td>

                                <td>
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
                                </td>

                                <td class="text-center">
                                    <a
                                        href="{{ route('admin.bookings.show', $booking->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        <i class="bi bi-eye me-1"></i>
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center text-secondary py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Không tìm thấy đơn đặt phòng phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Thông tin và phân trang --}}
            <div class="d-flex justify-content-between align-items-center mt-4">

                <div class="text-secondary small">
                    @if ($bookings->total() > 0)
                        Hiển thị {{ $bookings->firstItem() }}
                        - {{ $bookings->lastItem() }}
                        trong tổng số {{ $bookings->total() }} đơn
                    @else
                        Không có đơn đặt phòng nào.
                    @endif
                </div>

                <div class="ms-auto">
                    {{ $bookings->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>
    </div>

@endsection
