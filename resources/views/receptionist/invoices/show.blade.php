@extends('layouts.customer')

@section('title', 'Chi tiết hóa đơn | Vinpearl')

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
        height: 100%;
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

    .invoice-page .form-control,
    .invoice-page .form-select {
        min-height: 44px;
        border-radius: 10px;
    }

    .invoice-page .btn {
        border-radius: 10px;
        font-weight: 600;
    }

    .invoice-page .table > :not(caption) > * > * {
        padding: 13px 12px;
    }

    .invoice-page .table thead th {
        color: #52657a;
        font-size: .85rem;
        white-space: nowrap;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 12px;
    }

    .summary-total {
        color: #174d83;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .summary-remaining {
        color: #b42318;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .invoice-meta {
        color: #64748b;
        font-size: .9rem;
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
                <h1 class="page-title h2 mb-2">Chi tiết hóa đơn</h1>
                <p class="subtitle mb-0">
                    Mã hóa đơn:
                    <strong>{{ $invoice->invoice_number }}</strong>
                </p>
            </div>

            <a href="{{ route('receptionist.invoices.index') }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Danh sách hóa đơn
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

        {{-- Thông tin booking và tổng kết --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="invoice-card card">
                    <div class="card-body">
                        <h2 class="section-title h5 mb-4">
                            <i class="bi bi-person-vcard me-2"></i>
                            Thông tin khách hàng
                        </h2>

                        <div class="mb-3">
                            <div class="invoice-meta">Mã booking</div>
                            <div class="fw-semibold">{{ $invoice->booking_code }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="invoice-meta">Tên khách hàng</div>
                            <div class="fw-semibold">{{ $invoice->guest_name }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="invoice-meta">Số điện thoại</div>
                            <div class="fw-semibold">{{ $invoice->guest_phone }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="invoice-meta">Nhân viên lập hóa đơn</div>
                            <div class="fw-semibold">
                                {{ $invoice->issuer_name ?? 'Không xác định' }}
                            </div>
                        </div>

                        <div>
                            <div class="invoice-meta">Thời gian lập hóa đơn</div>
                            <div class="fw-semibold">
                                {{ \Carbon\Carbon::parse($invoice->issued_at)->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="invoice-card card">
                    <div class="card-body">
                        <h2 class="section-title h5 mb-4">
                            <i class="bi bi-calculator me-2"></i>
                            Tổng kết hóa đơn
                        </h2>

                        <div class="summary-row">
                            <span>Tiền phòng</span>
                            <strong>{{ number_format($invoice->room_charge, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="summary-row">
                            <span>Tiền dịch vụ</span>
                            <strong>{{ number_format($invoice->service_charge, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="summary-row">
                            <span>Giảm giá</span>
                            <strong>{{ number_format($invoice->discount, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="summary-row">
                            <span>Thuế</span>
                            <strong>{{ number_format($invoice->tax, 0, ',', '.') }} đ</strong>
                        </div>

                        <hr>

                        <div class="summary-row">
                            <span class="fw-semibold">Tổng cộng</span>
                            <span class="summary-total">
                                {{ number_format($invoice->total_amount, 0, ',', '.') }} đ
                            </span>
                        </div>

                        <div class="summary-row">
                            <span>Đã thanh toán</span>
                            <strong class="text-success">
                                {{ number_format($invoice->paid_amount, 0, ',', '.') }} đ
                            </strong>
                        </div>

                        <div class="summary-row mb-3">
                            <span>Còn phải trả</span>
                            <span class="summary-remaining">
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

        {{-- Chi tiết tiền phòng --}}
        <div class="invoice-card card mb-4">
            <div class="card-body">
                <h2 class="section-title h5 mb-3">
                    <i class="bi bi-door-open me-2"></i>
                    Chi tiết tiền phòng
                </h2>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Phòng</th>
                                <th>Nhận phòng</th>
                                <th>Trả phòng</th>
                                <th class="text-end">Số đêm</th>
                                <th class="text-end">Giá/đêm</th>
                                <th class="text-end">Thành tiền</th>
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

                                    <td class="text-end">{{ $room->nights }}</td>

                                    <td class="text-end text-nowrap">
                                        {{ number_format($room->price_per_night, 0, ',', '.') }} đ
                                    </td>

                                    <td class="text-end fw-semibold text-nowrap">
                                        {{ number_format($room->subtotal, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Không có dữ liệu phòng.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Chi tiết dịch vụ --}}
        <div class="invoice-card card mb-4">
            <div class="card-body">
                <h2 class="section-title h5 mb-3">
                    <i class="bi bi-cup-hot me-2"></i>
                    Chi tiết dịch vụ đã sử dụng
                </h2>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Dịch vụ</th>
                                <th>Phòng</th>
                                <th>Thời gian</th>
                                <th class="text-end">Số lượng</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td class="fw-semibold">{{ $service->service_name }}</td>
                                    <td>{{ $service->room_number ?? '—' }}</td>

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

                                    <td class="text-end fw-semibold text-nowrap">
                                        {{ number_format($service->total_price, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Khách chưa sử dụng dịch vụ nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ghi nhận thanh toán --}}
        <div class="invoice-card card mb-4">
            <div class="card-body">
                <h2 class="section-title h5 mb-2">
                    <i class="bi bi-credit-card me-2"></i>
                    Ghi nhận thanh toán
                </h2>

                <p class="subtitle mb-4">
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
                                Còn nợ: {{ number_format($invoice->remaining_amount, 0, ',', '.') }} đ
                            </small>
                        </div>

                        <div class="col-md-4">
                            <label for="method" class="form-label">
                                Phương thức thanh toán
                            </label>

                            <select id="method" name="method" class="form-select" required>
                                <option value="cash" @selected(old('method', 'cash') === 'cash')>
                                    Tiền mặt
                                </option>
                                <option value="bank_transfer" @selected(old('method') === 'bank_transfer')>
                                    Chuyển khoản ngân hàng
                                </option>
                                <option value="card" @selected(old('method') === 'card')>
                                    Thẻ ngân hàng
                                </option>
                                <option value="vnpay" @selected(old('method') === 'vnpay')>
                                    VNPay — ghi nhận thủ công
                                </option>
                                <option value="momo" @selected(old('method') === 'momo')>
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

                            <button type="submit" class="btn btn-success">
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

        {{-- Lịch sử thanh toán --}}
        <div class="invoice-card card">
            <div class="card-body">
                <h2 class="section-title h5 mb-3">
                    <i class="bi bi-clock-history me-2"></i>
                    Lịch sử thanh toán
                </h2>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Thời gian</th>
                                <th>Phương thức</th>
                                <th>Mã giao dịch</th>
                                <th>Nhân viên</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Số tiền</th>
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

                                    <td>{{ $payment->transaction_ref ?: '—' }}</td>

                                    <td>{{ $payment->receiver_name ?? '—' }}</td>

                                    <td>
                                        <span class="badge text-bg-{{ $paymentColor }}">
                                            {{ $paymentLabel }}
                                        </span>
                                    </td>

                                    <td class="text-end fw-semibold text-nowrap">
                                        {{ number_format($payment->amount, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
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
</div>
@endsection