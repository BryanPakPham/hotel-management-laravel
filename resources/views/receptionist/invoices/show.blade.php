
@extends('layouts.receptionist')

@section('title', 'Chi tiết hóa đơn')
@section('page-heading', 'Chi tiết hóa đơn')
@section('breadcrumb', 'Trang chủ / Quản lý hóa đơn / Chi tiết')

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
    .invoice-detail-page {
        color: #344054;
    }

    .invoice-detail-card {
        height: 100%;
        background: white;
        border: 1px solid #e7e9ed;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
    }

    .invoice-detail-card .card-body {
        padding: 24px;
    }

    .invoice-detail-title {
        color: #17324d;
        font-size: 17px;
        font-weight: 700;
    }

    .invoice-detail-number {
        color: #17324d;
        font-weight: 700;
    }

    .invoice-detail-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f4efe4;
        color: #b49a65;
        border-radius: 10px;
        font-size: 20px;
        flex-shrink: 0;
    }

    .invoice-detail-meta {
        color: #7a8491;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .invoice-detail-info {
        color: #344054;
        font-size: 14px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .invoice-detail-subtitle {
        color: #7a8491;
        font-size: 13px;
    }

    .invoice-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 14px;
        font-size: 13px;
    }

    .invoice-summary-total {
        color: #17324d;
        font-size: 22px;
        font-weight: 800;
        white-space: nowrap;
    }

    .invoice-summary-remaining {
        color: #b42318;
        font-size: 19px;
        font-weight: 800;
        white-space: nowrap;
    }

    .invoice-summary-paid {
        color: #198754;
        font-weight: 700;
        white-space: nowrap;
    }

    .invoice-detail-table {
        margin-bottom: 0;
        vertical-align: middle;
    }

    .invoice-detail-table thead th {
        padding: 15px 13px;
        background: #f8f9fb;
        color: #647084;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .3px;
        white-space: nowrap;
        border-bottom: 1px solid #e7e9ed;
    }

    .invoice-detail-table tbody td {
        padding: 14px 13px;
        font-size: 13px;
        border-color: #eef0f3;
    }

    .invoice-detail-table tbody tr:hover td {
        background: #fcfaf5;
    }

    .invoice-detail-amount {
        color: #17324d;
        font-weight: 700;
        white-space: nowrap;
    }

    .invoice-detail-empty {
        text-align: center;
        padding: 35px 15px !important;
        color: #7a8491;
        white-space: normal !important;
    }

    .invoice-detail-page .form-label {
        color: #344054;
        font-size: 13px;
        font-weight: 600;
    }

    .invoice-detail-page .form-control,
    .invoice-detail-page .form-select {
        min-height: 43px;
        border: 1px solid #e7e9ed;
        border-radius: 6px;
        font-size: 13px;
    }

    .invoice-detail-page .form-control:focus,
    .invoice-detail-page .form-select:focus {
        border-color: #b49a65;
        box-shadow: 0 0 0 .2rem rgba(180, 154, 101, .12);
    }

    .invoice-detail-payment-btn {
        padding: 10px 18px;
        color: white;
        background: #17324d;
        border: 1px solid #17324d;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        transition: .2s;
    }

    .invoice-detail-payment-btn:hover {
        color: white;
        background: #b49a65;
        border-color: #b49a65;
    }

    @media (max-width: 767px) {
        .invoice-detail-card .card-body {
            padding: 18px;
        }

        .invoice-summary-total {
            font-size: 18px;
        }

        .invoice-summary-remaining {
            font-size: 17px;
        }
    }
</style>
@endpush

@section('content')
<div class="invoice-detail-page">

    {{-- TIÊU ĐỀ --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-2" style="color: #17324d;">
                    Chi tiết hóa đơn
                </h3>

                <p class="text-secondary mb-0" style="font-size: 14px;">
                    Mã hóa đơn:
                    <strong class="invoice-detail-number">
                        {{ $invoice->invoice_number }}
                    </strong>
                </p>
            </div>

            <a href="{{ route('receptionist.invoices.index') }}"
                class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Danh sách hóa đơn
            </a>
        </div>
    </div>

    {{-- THÔNG TIN KHÁCH HÀNG VÀ TỔNG KẾT --}}
    <div class="row g-4 mb-4">

        {{-- THÔNG TIN KHÁCH HÀNG --}}
        <div class="col-lg-6">
            <div class="invoice-detail-card">
                <div class="card-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="invoice-detail-icon">
                            <i class="bi bi-person-vcard"></i>
                        </div>

                        <h2 class="invoice-detail-title mb-0">
                            Thông tin khách hàng
                        </h2>
                    </div>

                    <div class="mb-3">
                        <div class="invoice-detail-meta">Mã booking</div>
                        <div class="invoice-detail-info">
                            {{ $invoice->booking_code }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="invoice-detail-meta">Tên khách hàng</div>
                        <div class="invoice-detail-info">
                            {{ $invoice->guest_name }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="invoice-detail-meta">Số điện thoại</div>
                        <div class="invoice-detail-info">
                            {{ $invoice->guest_phone }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="invoice-detail-meta">Nhân viên lập hóa đơn</div>
                        <div class="invoice-detail-info">
                            {{ $invoice->issuer_name ?? 'Không xác định' }}
                        </div>
                    </div>

                    <div>
                        <div class="invoice-detail-meta">Thời gian lập hóa đơn</div>
                        <div class="invoice-detail-info">
                            {{ \Carbon\Carbon::parse($invoice->issued_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- TỔNG KẾT HÓA ĐƠN --}}
        <div class="col-lg-6">
            <div class="invoice-detail-card">
                <div class="card-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="invoice-detail-icon">
                            <i class="bi bi-calculator"></i>
                        </div>

                        <h2 class="invoice-detail-title mb-0">
                            Tổng kết hóa đơn
                        </h2>
                    </div>

                    <div class="invoice-summary-row">
                        <span>Tiền phòng</span>
                        <strong>
                            {{ number_format($invoice->room_charge, 0, ',', '.') }} đ
                        </strong>
                    </div>

                    <div class="invoice-summary-row">
                        <span>Tiền dịch vụ</span>
                        <strong>
                            {{ number_format($invoice->service_charge, 0, ',', '.') }} đ
                        </strong>
                    </div>

                    <div class="invoice-summary-row">
                        <span>Giảm giá</span>
                        <strong>
                            {{ number_format($invoice->discount, 0, ',', '.') }} đ
                        </strong>
                    </div>

                    <div class="invoice-summary-row">
                        <span>Thuế</span>
                        <strong>
                            {{ number_format($invoice->tax, 0, ',', '.') }} đ
                        </strong>
                    </div>

                    <hr>

                    <div class="invoice-summary-row">
                        <span class="fw-semibold">Tổng cộng</span>
                        <span class="invoice-summary-total">
                            {{ number_format($invoice->total_amount, 0, ',', '.') }} đ
                        </span>
                    </div>

                    <div class="invoice-summary-row">
                        <span>Đã thanh toán</span>
                        <strong class="invoice-summary-paid">
                            {{ number_format($invoice->paid_amount, 0, ',', '.') }} đ
                        </strong>
                    </div>

                    <div class="invoice-summary-row mb-3">
                        <span>Còn phải trả</span>
                        <span class="invoice-summary-remaining">
                            {{ number_format($invoice->remaining_amount, 0, ',', '.') }} đ
                        </span>
                    </div>

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

                    <span class="badge text-bg-{{ $statusColor }} fs-6">
                        {{ $statusLabel }}
                    </span>

                </div>
            </div>
        </div>
    </div>

    {{-- CHI TIẾT TIỀN PHÒNG --}}
    <div class="invoice-detail-card mb-4">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="invoice-detail-icon">
                    <i class="bi bi-door-open"></i>
                </div>

                <h2 class="invoice-detail-title mb-0">
                    Chi tiết tiền phòng
                </h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover invoice-detail-table">
                    <thead>
                        <tr>
                            <th>PHÒNG</th>
                            <th>NHẬN PHÒNG</th>
                            <th>TRẢ PHÒNG</th>
                            <th class="text-end">SỐ ĐÊM</th>
                            <th class="text-end">GIÁ/ĐÊM</th>
                            <th class="text-end">THÀNH TIỀN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $room->room_number ?? 'Chưa gán phòng' }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $room->actual_check_in
                                        ? \Carbon\Carbon::parse($room->actual_check_in)->format('d/m/Y H:i')
                                        : '—' }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $room->actual_check_out
                                        ? \Carbon\Carbon::parse($room->actual_check_out)->format('d/m/Y H:i')
                                        : '—' }}
                                </td>

                                <td class="text-end">
                                    {{ $room->nights }}
                                </td>

                                <td class="text-end text-nowrap">
                                    {{ number_format($room->price_per_night, 0, ',', '.') }} đ
                                </td>

                                <td class="text-end invoice-detail-amount">
                                    {{ number_format($room->subtotal, 0, ',', '.') }} đ
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="invoice-detail-empty">
                                    Không có dữ liệu phòng.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- CHI TIẾT DỊCH VỤ --}}
    <div class="invoice-detail-card mb-4">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="invoice-detail-icon">
                    <i class="bi bi-cup-hot"></i>
                </div>

                <h2 class="invoice-detail-title mb-0">
                    Chi tiết dịch vụ đã sử dụng
                </h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover invoice-detail-table">
                    <thead>
                        <tr>
                            <th>DỊCH VỤ</th>
                            <th>PHÒNG</th>
                            <th>THỜI GIAN</th>
                            <th class="text-end">SỐ LƯỢNG</th>
                            <th class="text-end">ĐƠN GIÁ</th>
                            <th class="text-end">THÀNH TIỀN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $service->service_name }}
                                </td>

                                <td>
                                    {{ $service->room_number ?? '—' }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $service->used_at
                                        ? \Carbon\Carbon::parse($service->used_at)->format('d/m/Y H:i')
                                        : '—' }}
                                </td>

                                <td class="text-end">
                                    {{ $service->quantity }} {{ $service->unit }}
                                </td>

                                <td class="text-end text-nowrap">
                                    {{ number_format($service->unit_price, 0, ',', '.') }} đ
                                </td>

                                <td class="text-end invoice-detail-amount">
                                    {{ number_format($service->total_price, 0, ',', '.') }} đ
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="invoice-detail-empty">
                                    Khách chưa sử dụng dịch vụ nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- GHI NHẬN THANH TOÁN --}}
    <div class="invoice-detail-card mb-4">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="invoice-detail-icon">
                    <i class="bi bi-credit-card"></i>
                </div>

                <h2 class="invoice-detail-title mb-0">
                    Ghi nhận thanh toán
                </h2>
            </div>

            <p class="invoice-detail-subtitle mb-4">
                Nhập số tiền thực tế khách đã thanh toán và chọn phương thức tương ứng.
            </p>

            @if(in_array($invoice->status, ['unpaid', 'partial'])
                && $invoice->remaining_amount > 0)

                <form action="{{ route('receptionist.invoices.payments.store', $invoice->id) }}"
                    method="POST" class="row g-3">

                    @csrf

                    <div class="col-md-4">
                        <label for="amount" class="form-label">
                            Số tiền thanh toán (VNĐ)
                        </label>

                        <input type="number"
                            id="amount"
                            name="amount"
                            class="form-control"
                            min="0.01"
                            step="0.01"
                            max="{{ $invoice->remaining_amount }}"
                            value="{{ old('amount', $invoice->remaining_amount) }}"
                            required>

                        <small class="text-muted">
                            Còn nợ:
                            {{ number_format($invoice->remaining_amount, 0, ',', '.') }} đ
                        </small>
                    </div>

                    <div class="col-md-4">
                        <label for="method" class="form-label">
                            Phương thức thanh toán
                        </label>

                        <select id="method" name="method" class="form-select" required>
                            <option value="cash"
                                @selected(old('method', 'cash') === 'cash')>
                                Tiền mặt
                            </option>

                            <option value="bank_transfer"
                                @selected(old('method') === 'bank_transfer')>
                                Chuyển khoản ngân hàng
                            </option>

                            <option value="card"
                                @selected(old('method') === 'card')>
                                Thẻ ngân hàng
                            </option>

                            <option value="vnpay"
                                @selected(old('method') === 'vnpay')>
                                VNPay — ghi nhận thủ công
                            </option>

                            <option value="momo"
                                @selected(old('method') === 'momo')>
                                MoMo — ghi nhận thủ công
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="transaction_ref" class="form-label">
                            Mã giao dịch (không bắt buộc)
                        </label>

                        <input type="text"
                            id="transaction_ref"
                            name="transaction_ref"
                            class="form-control"
                            maxlength="100"
                            value="{{ old('transaction_ref') }}"
                            placeholder="Nhập mã giao dịch nếu có">
                    </div>

                    <div class="col-12">
                        <div class="alert alert-warning small">
                            <i class="bi bi-info-circle me-1"></i>
                            Chỉ xác nhận thanh toán thành công sau khi đã kiểm tra tiền thực nhận.
                            VNPay và MoMo tại giao diện này là ghi nhận thủ công, chưa tích hợp cổng thanh toán.
                        </div>

                        <button type="submit" class="btn invoice-detail-payment-btn">
                            <i class="bi bi-check-circle me-1"></i>
                            Xác nhận thanh toán
                        </button>
                    </div>

                </form>

            @elseif($invoice->status === 'refunded')

                <div class="alert alert-secondary mb-0">
                    Hóa đơn đã hoàn tiền, không thể ghi nhận thanh toán mới.
                </div>

            @else

                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Hóa đơn đã được thanh toán đủ.
                </div>

            @endif

        </div>
    </div>

    {{-- LỊCH SỬ THANH TOÁN --}}
    <div class="invoice-detail-card">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="invoice-detail-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <h2 class="invoice-detail-title mb-0">
                    Lịch sử thanh toán
                </h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover invoice-detail-table">
                    <thead>
                        <tr>
                            <th>THỜI GIAN</th>
                            <th>PHƯƠNG THỨC</th>
                            <th>MÃ GIAO DỊCH</th>
                            <th>NHÂN VIÊN</th>
                            <th>TRẠNG THÁI</th>
                            <th class="text-end">SỐ TIỀN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)

                            @php
                                $methodLabels = [
                                    'cash' => 'Tiền mặt',
                                    'bank_transfer' => 'Chuyển khoản',
                                    'card' => 'Thẻ ngân hàng',
                                    'vnpay' => 'VNPay',
                                    'momo' => 'MoMo',
                                ];

                                $paymentStatusInfo = [
                                    'pending' => ['Đang xử lý', 'warning'],
                                    'success' => ['Thành công', 'success'],
                                    'failed' => ['Thất bại', 'danger'],
                                    'refunded' => ['Đã hoàn tiền', 'secondary'],
                                ];

                                [$paymentLabel, $paymentColor] =
                                    $paymentStatusInfo[$payment->status]
                                    ?? ['Không xác định', 'secondary'];
                            @endphp

                            <tr>
                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    {{ $methodLabels[$payment->method] ?? $payment->method }}
                                </td>

                                <td>
                                    {{ $payment->transaction_ref ?: '—' }}
                                </td>

                                <td>
                                    {{ $payment->receiver_name ?? '—' }}
                                </td>

                                <td>
                                    <span class="badge text-bg-{{ $paymentColor }}">
                                        {{ $paymentLabel }}
                                    </span>
                                </td>

                                <td class="text-end invoice-detail-amount">
                                    {{ number_format($payment->amount, 0, ',', '.') }} đ
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="invoice-detail-empty">
                                    Chưa có giao dịch thanh toán nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
