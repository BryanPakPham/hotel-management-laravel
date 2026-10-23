@extends('layouts.customer')

@section('title', 'Quản lý hóa đơn | Vinpearl')

@push('styles')
<style>
    .customer-hero,
    .booking-section,
    .hotel-video-section {
        display: none !important;
    }

    .invoice-page {
        min-height: 60vh;
        padding: 40px 0 64px;
        background: #f6f8fb;
    }

    .invoice-page .page-title {
        color: #15365b;
        font-weight: 750;
    }

    .invoice-page .subtitle {
        color: #718096;
    }

    .invoice-card {
        border: 1px solid #e8edf3;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(20, 49, 80, .06);
    }

    .invoice-card .card-body {
        padding: 24px;
    }

    .invoice-page .section-title {
        color: #173d66;
        font-weight: 700;
    }

    .invoice-page .form-label {
        font-weight: 600;
        color: #34465a;
    }

    .invoice-page .form-select,
    .invoice-page .form-control {
        min-height: 44px;
        border-radius: 10px;
    }

    .invoice-page .btn {
        border-radius: 10px;
        font-weight: 600;
    }

    .invoice-page .table > :not(caption) > * > * {
        padding: 14px 12px;
    }

    .invoice-page .table thead th {
        color: #52657a;
        font-size: .85rem;
        white-space: nowrap;
    }

    .invoice-number {
        color: #174d83;
        font-weight: 700;
    }

    .amount {
        font-weight: 700;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .invoice-page {
            padding: 24px 0 40px;
        }

        .invoice-card .card-body {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')
<div class="invoice-page">
    <div class="container">

        {{-- Tiêu đề --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <div class="text-uppercase small text-primary fw-bold mb-2">
                    Receptionist · Billing
                </div>
                <h1 class="page-title h2 mb-2">Quản lý hóa đơn</h1>
                <p class="subtitle mb-0">
                    Lập hóa đơn phòng, dịch vụ và theo dõi tình trạng thanh toán.
                </p>
            </div>

            <a href="{{ route('receptionist.dashboard') }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Trang lễ tân
            </a>
        </div>

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Đóng"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Đóng"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Vui lòng kiểm tra lại:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Lập hóa đơn --}}
        <div class="invoice-card card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-3 bg-primary-subtle text-primary p-3">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                    <div>
                        <h2 class="section-title h5 mb-1">Lập hóa đơn mới</h2>
                        <p class="subtitle mb-0">
                            Chọn booking đã trả phòng và chưa có hóa đơn.
                        </p>
                    </div>
                </div>

                @if($bookings->isNotEmpty())
                    <form action="{{ route('receptionist.invoices.store') }}"
                          method="POST"
                          class="row g-3 align-items-end">
                        @csrf

                        <div class="col-lg-9">
                            <label for="booking_id" class="form-label">
                                Booking cần lập hóa đơn
                            </label>

                            <select name="booking_id" id="booking_id"
                                    class="form-select" required>
                                <option value="">-- Chọn booking --</option>

                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}"
                                        @selected(old('booking_id') == $booking->id)>
                                        {{ $booking->booking_code }}
                                        — {{ $booking->guest_name }}
                                        — {{ $booking->guest_phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle me-1"></i>
                                Lập hóa đơn
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Chưa có booking nào đủ điều kiện lập hóa đơn.
                        Booking cần được check-out đầy đủ trước khi lập hóa đơn.
                    </div>
                @endif
            </div>
        </div>

        {{-- Danh sách hóa đơn --}}
        <div class="invoice-card card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                        <h2 class="section-title h5 mb-1">Danh sách hóa đơn</h2>
                        <p class="subtitle small mb-0">
                            Tổng số hóa đơn: {{ $invoices->count() }}
                        </p>
                    </div>

                    <span class="badge text-bg-light border">
                        <i class="bi bi-clock-history me-1"></i>
                        Cập nhật theo dữ liệu hiện tại
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Booking / Khách hàng</th>
                                <th>Ngày lập</th>
                                <th class="text-end">Tổng tiền</th>
                                <th class="text-end">Đã trả</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($invoices as $invoice)
                                @php
                                    $statusInfo = [
                                        'unpaid' => ['Chưa thanh toán', 'danger'],
                                        'partial' => ['Thanh toán một phần', 'warning'],
                                        'paid' => ['Đã thanh toán', 'success'],
                                        'refunded' => ['Đã hoàn tiền', 'secondary'],
                                    ];

                                    [$statusLabel, $statusColor] =
                                        $statusInfo[$invoice->status]
                                        ?? ['Không xác định', 'secondary'];
                                @endphp

                                <tr>
                                    <td>
                                        <span class="invoice-number">
                                            {{ $invoice->invoice_number }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $invoice->booking_code }}
                                        </div>
                                        <div>{{ $invoice->guest_name }}</div>
                                        <small class="text-muted">
                                            {{ $invoice->guest_phone }}
                                        </small>
                                    </td>

                                    <td class="text-nowrap">
                                        {{ \Carbon\Carbon::parse($invoice->issued_at)->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="text-end amount">
                                        {{ number_format($invoice->total_amount, 0, ',', '.') }} đ
                                    </td>

                                    <td class="text-end text-nowrap">
                                        {{ number_format($invoice->paid_amount, 0, ',', '.') }} đ
                                    </td>

                                    <td>
                                        <span class="badge text-bg-{{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('receptionist.invoices.show', $invoice->id) }}"
                                           class="btn btn-sm btn-outline-primary text-nowrap">
                                            <i class="bi bi-eye me-1"></i>
                                            Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-receipt-cutoff fs-2 text-muted"></i>
                                        <p class="fw-semibold mt-2 mb-1">
                                            Chưa có hóa đơn
                                        </p>
                                        <p class="text-muted small mb-0">
                                            Hóa đơn sẽ xuất hiện ở đây sau khi được lập.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection