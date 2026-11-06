
@extends('layouts.receptionist')

@section('title', 'Quản lý hóa đơn')
@section('page-heading', 'Quản lý hóa đơn')
@section('breadcrumb', 'Trang chủ / Quản lý hóa đơn')

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
    .invoice-page {
        color: #344054;
    }

    .invoice-card {
        background: white;
        border: 1px solid #e7e9ed;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
    }

    .invoice-card .card-body {
        padding: 24px;
    }

    .invoice-section-title {
        color: #17324d;
        font-size: 17px;
        font-weight: 700;
    }

    .invoice-section-description {
        color: #7a8491;
        font-size: 13px;
    }

    .invoice-section-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f4efe4;
        color: #b49a65;
        border-radius: 10px;
        font-size: 22px;
        flex-shrink: 0;
    }

    .invoice-page .form-label {
        color: #344054;
        font-size: 13px;
        font-weight: 600;
    }

    .invoice-page .form-select {
        min-height: 43px;
        border: 1px solid #e7e9ed;
        border-radius: 6px;
        font-size: 13px;
    }

    .invoice-page .form-select:focus {
        border-color: #b49a65;
        box-shadow: 0 0 0 .2rem rgba(180, 154, 101, .12);
    }

    .invoice-btn-create {
        min-height: 43px;
        background: #17324d;
        color: white;
        border: 1px solid #17324d;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        transition: .2s;
    }

    .invoice-btn-create:hover {
        background: #b49a65;
        border-color: #b49a65;
        color: white;
    }

    .invoice-table {
        margin-bottom: 0;
        vertical-align: middle;
    }

    .invoice-table thead th {
        padding: 16px 14px;
        background: #f8f9fb;
        color: #647084;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .3px;
        white-space: nowrap;
        border-bottom: 1px solid #e7e9ed;
    }

    .invoice-table tbody td {
        padding: 16px 14px;
        font-size: 13px;
        border-color: #eef0f3;
    }

    .invoice-table tbody tr:hover td {
        background: #fcfaf5;
    }

    .invoice-number {
        color: #17324d;
        font-weight: 700;
    }

    .invoice-subtext {
        color: #7a8491;
        font-size: 12px;
    }

    .invoice-amount {
        color: #17324d;
        font-weight: 700;
        white-space: nowrap;
    }

    .invoice-record-count {
        display: inline-block;
        padding: 7px 12px;
        color: #927640;
        background: #f7f2e8;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .invoice-btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        color: #17324d;
        background: white;
        border: 1px solid #17324d;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s;
    }

    .invoice-btn-detail:hover {
        color: white;
        background: #17324d;
    }

    .invoice-empty-state {
        text-align: center;
        padding: 45px 20px !important;
        color: #7a8491;
        white-space: normal !important;
    }

    .invoice-empty-state i {
        display: block;
        color: #b49a65;
        font-size: 35px;
        margin-bottom: 10px;
    }

    @media (max-width: 767px) {
        .invoice-card .card-body {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')
<div class="invoice-page">

    {{-- THÔNG TIN TRANG --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="color: #17324d;">
            Quản lý hóa đơn
        </h3>

        <p class="text-secondary mb-0" style="font-size: 14px;">
            Lập hóa đơn phòng, dịch vụ và theo dõi tình trạng thanh toán.
        </p>
    </div>

    {{-- LẬP HÓA ĐƠN --}}
    <div class="invoice-card mb-4">
        <div class="card-body">

            <div class="d-flex align-items-start gap-3 mb-4">
                <div class="invoice-section-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <div>
                    <h2 class="invoice-section-title mb-1">
                        Lập hóa đơn mới
                    </h2>

                    <p class="invoice-section-description mb-0">
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
                        <button type="submit" class="btn invoice-btn-create w-100">
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

    {{-- DANH SÁCH HÓA ĐƠN --}}
    <div class="invoice-card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="invoice-section-title mb-1">
                        <i class="bi bi-list-ul me-2" style="color: #b49a65;"></i>
                        Danh sách hóa đơn
                    </h2>

                    <p class="invoice-section-description mb-0">
                        Theo dõi thông tin và tình trạng thanh toán của hóa đơn.
                    </p>
                </div>

                <span class="invoice-record-count">
                    <i class="bi bi-receipt me-1"></i>
                    Tổng số: {{ $invoices->count() }} hóa đơn
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover invoice-table">
                    <thead>
                        <tr>
                            <th>MÃ HÓA ĐƠN</th>
                            <th>BOOKING / KHÁCH HÀNG</th>
                            <th>NGÀY LẬP</th>
                            <th class="text-end">TỔNG TIỀN</th>
                            <th class="text-end">ĐÃ TRẢ</th>
                            <th>TRẠNG THÁI</th>
                            <th class="text-center">THAO TÁC</th>
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

                                    <div>
                                        {{ $invoice->guest_name }}
                                    </div>

                                    <div class="invoice-subtext">
                                        {{ $invoice->guest_phone }}
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($invoice->issued_at)->format('d/m/Y H:i') }}
                                </td>

                                <td class="text-end invoice-amount">
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
                                        class="invoice-btn-detail">

                                        <i class="bi bi-eye"></i>
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="invoice-empty-state">
                                    <i class="bi bi-receipt-cutoff"></i>

                                    <strong class="d-block mb-2">
                                        Chưa có hóa đơn
                                    </strong>

                                    <span>
                                        Hóa đơn sẽ xuất hiện ở đây sau khi được lập.
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-3 mt-3 border-top text-muted small">
                Hiển thị {{ $invoices->count() }} hóa đơn.
            </div>

        </div>
    </div>

</div>
@endsection
