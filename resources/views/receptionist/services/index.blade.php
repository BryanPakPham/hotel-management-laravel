
@extends('layouts.customer')

@section('title', 'Quản lý dịch vụ | Vinpearl')

@push('styles')
<style>
    /* Ẩn các phần dành riêng cho trang chủ khách hàng */
    .customer-hero,
    .booking-section,
    .hotel-video-section {
        display: none !important;
    }

    .service-page {
        min-height: 70vh;
        padding: 45px 0 65px;
        background: #f7f8fa;
        color: #243447;
    }

    .service-heading {
        margin-bottom: 30px;
    }

    .service-eyebrow {
        color: #a78645;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .service-heading h1 {
        margin: 10px 0;
        color: #173c35;
        font-size: clamp(26px, 4vw, 36px);
        font-weight: 700;
    }

    .service-heading p {
        margin-bottom: 0;
        color: #718096;
    }

    .service-card {
        height: 100%;
        padding: 25px;
        border: 1px solid #e8ecef;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(25, 55, 45, .05);
    }

    .service-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
    }

    .service-card-title h2 {
        margin: 0;
        color: #173c35;
        font-size: 19px;
        font-weight: 700;
    }

    .service-icon {
        display: grid;
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 12px;
        background: #edf5f0;
        color: #24664e;
        font-size: 21px;
    }

    .service-page .form-label {
        margin-bottom: 8px;
        color: #344054;
        font-size: 13px;
        font-weight: 600;
    }

    .service-page .form-control,
    .service-page .form-select {
        min-height: 46px;
        border-color: #dce3e7;
        border-radius: 9px;
        font-size: 14px;
    }

    .service-page .form-control:focus,
    .service-page .form-select:focus {
        border-color: #779d8c;
        box-shadow: 0 0 0 .2rem rgba(36, 102, 78, .10);
    }

    .service-price-preview {
        margin: 20px 0;
        padding: 18px;
        border: 1px dashed #b8cbbf;
        border-radius: 12px;
        background: #f5faf6;
    }

    .service-price-preview .preview-label {
        color: #64756c;
        font-size: 13px;
    }

    .service-price-preview .preview-total {
        display: block;
        margin-top: 5px;
        color: #1b6548;
        font-size: 27px;
        font-weight: 800;
    }

    .btn-service-submit {
        width: 100%;
        min-height: 47px;
        border: 0;
        border-radius: 9px;
        background: #1e5945;
        color: #fff;
        font-weight: 600;
        transition: .2s;
    }

    .btn-service-submit:hover {
        background: #164333;
        color: #fff;
    }

    .service-summary {
        display: flex;
        align-items: center;
        gap: 15px;
        height: 100%;
        padding: 20px;
        border: 1px solid #e8ecef;
        border-radius: 14px;
        background: #fff;
    }

    .summary-icon {
        display: grid;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 14px;
        background: #f6f0e3;
        color: #a78645;
        font-size: 22px;
    }

    .summary-label {
        color: #75818d;
        font-size: 13px;
    }

    .summary-value {
        margin-top: 3px;
        color: #173c35;
        font-size: 24px;
        font-weight: 750;
    }

    .service-table-card {
        margin-top: 28px;
        overflow: hidden;
        border: 1px solid #e8ecef;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(25, 55, 45, .04);
    }

    .service-table-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 22px 24px;
        border-bottom: 1px solid #edf0f2;
    }

    .service-table-heading h2 {
        margin: 0;
        color: #173c35;
        font-size: 18px;
        font-weight: 700;
    }

    .service-search {
        width: min(100%, 280px);
        min-height: 40px;
        border: 1px solid #dce3e7;
        border-radius: 9px;
        padding: 8px 12px;
        font-size: 13px;
    }

    .service-table-wrapper {
        overflow-x: auto;
    }

    .service-table {
        width: 100%;
        margin: 0;
        white-space: nowrap;
        vertical-align: middle;
    }

    .service-table thead th {
        padding: 15px 18px;
        background: #f8faf9;
        color: #64756c;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .service-table tbody td {
        padding: 15px 18px;
        border-color: #f0f2f3;
        color: #465465;
        font-size: 13px;
    }

    .service-table tbody tr:hover {
        background: #fbfdfb;
    }

    .guest-name {
        color: #263f35;
        font-weight: 650;
    }

    .room-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 7px;
        background: #edf5f0;
        color: #24664e;
        font-weight: 700;
    }

    .status-active {
        padding: 5px 9px;
        border-radius: 20px;
        background: #e8f6ed;
        color: #247444;
        font-size: 11px;
        font-weight: 700;
    }

    .status-inactive {
        padding: 5px 9px;
        border-radius: 20px;
        background: #fbeaea;
        color: #b42318;
        font-size: 11px;
        font-weight: 700;
    }

    .empty-state {
        padding: 35px 15px !important;
        color: #8a96a3 !important;
        text-align: center;
        white-space: normal;
    }

    .service-alert {
        border: 0;
        border-radius: 10px;
    }

    @media (max-width: 767px) {
        .service-page {
            padding: 30px 0 45px;
        }

        .service-card {
            padding: 20px;
        }

        .service-table-heading {
            align-items: stretch;
            flex-direction: column;
            padding: 18px;
        }

        .service-search {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="service-page">
    <div class="container">

        {{-- Tiêu đề --}}
        <div class="service-heading">
            <span class="service-eyebrow">VINPEARL · RECEPTIONIST</span>
            <h1>Quản lý dịch vụ</h1>
            <p>Ghi nhận dịch vụ khách sử dụng trong thời gian lưu trú.</p>
        </div>

        {{-- Thông báo kết quả --}}
        @if (session('success'))
            <div class="alert alert-success service-alert alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger service-alert alert-dismissible fade show">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger service-alert">
                <strong>Không thể ghi nhận dịch vụ:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Thẻ thống kê --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="service-summary">
                    <div class="summary-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div>
                        <div class="summary-label">Khách đang lưu trú</div>
                        <div class="summary-value">{{ $luuTru->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="service-summary">
                    <div class="summary-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="summary-label">Lượt dịch vụ đã ghi nhận</div>
                        <div class="summary-value">{{ $daSuDung->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Form ghi nhận --}}
            <div class="col-lg-5">
                <div class="service-card">
                    <div class="service-card-title">
                        <div class="service-icon">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div>
                            <h2>Ghi nhận dịch vụ</h2>
                            <small class="text-secondary">Nhập thông tin sử dụng</small>
                        </div>
                    </div>

                    @if ($luuTru->isEmpty())
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Hiện chưa có khách đang lưu trú để ghi nhận dịch vụ.
                        </div>
                    @elseif ($dichVu->where('is_active', 1)->isEmpty())
                        <div class="alert alert-warning mb-0">
                            Hiện chưa có dịch vụ nào đang hoạt động.
                        </div>
                    @else
                        <form action="{{ route('receptionist.services.store') }}"
                              method="POST"
                              id="serviceForm">
                            @csrf

                            <div class="mb-3">
                                <label for="stay_record_id" class="form-label">
                                    Khách hàng / Phòng <span class="text-danger">*</span>
                                </label>

                                <select name="stay_record_id"
                                        id="stay_record_id"
                                        class="form-select"
                                        required>
                                    <option value="">-- Chọn khách đang lưu trú --</option>

                                    @foreach ($luuTru as $khach)
                                        <option value="{{ $khach->stay_id }}"
                                            {{ old('stay_record_id') == $khach->stay_id ? 'selected' : '' }}>
                                            Phòng {{ $khach->room_number }}
                                            - {{ $khach->guest_name }}
                                            ({{ $khach->booking_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="service_id" class="form-label">
                                    Dịch vụ <span class="text-danger">*</span>
                                </label>

                                <select name="service_id"
                                        id="service_id"
                                        class="form-select"
                                        required>
                                    <option value="">-- Chọn dịch vụ --</option>

                                    @foreach ($dichVu as $dv)
                                        @if ($dv->is_active == 1)
                                            <option value="{{ $dv->id }}"
                                                data-price="{{ $dv->price }}"
                                                data-unit="{{ $dv->unit }}"
                                                {{ old('service_id') == $dv->id ? 'selected' : '' }}>
                                                {{ $dv->name }}
                                                - {{ number_format($dv->price, 0, ',', '.') }} đ/{{ $dv->unit }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">
                                    Số lượng <span class="text-danger">*</span>
                                </label>

                                <input type="number"
                                       name="quantity"
                                       id="quantity"
                                       class="form-control"
                                       min="1"
                                       max="1000"
                                       step="1"
                                       value="{{ old('quantity', 1) }}"
                                       required>

                                <small class="text-secondary">
                                    Nhập số lượng theo đơn vị của dịch vụ.
                                </small>
                            </div>

                            <div class="service-price-preview">
                                <span class="preview-label">
                                    <i class="bi bi-calculator me-1"></i>
                                    Tổng tiền dự kiến
                                </span>
                                <span class="preview-total" id="serviceTotal">0 đ</span>
                                <small class="text-secondary" id="serviceUnitPrice">
                                    Chọn dịch vụ để xem đơn giá.
                                </small>
                            </div>

                            <button type="submit" class="btn btn-service-submit">
                                <i class="bi bi-check2-circle me-2"></i>
                                Xác nhận ghi nhận
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Danh mục dịch vụ --}}
            <div class="col-lg-7">
                <div class="service-card">
                    <div class="service-card-title">
                        <div class="service-icon">
                            <i class="bi bi-grid"></i>
                        </div>
                        <div>
                            <h2>Danh mục dịch vụ</h2>
                            <small class="text-secondary">Đơn giá được lấy từ cơ sở dữ liệu</small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table service-table">
                            <thead>
                                <tr>
                                    <th>Tên dịch vụ</th>
                                    <th>Đơn giá</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dichVu as $dv)
                                    <tr>
                                        <td>
                                            <div class="guest-name">{{ $dv->name }}</div>
                                            @if (!empty($dv->description))
                                                <small class="text-secondary">
                                                    {{ $dv->description }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>
                                                {{ number_format($dv->price, 0, ',', '.') }} đ
                                            </strong>
                                            <small class="text-secondary">
                                                /{{ $dv->unit }}
                                            </small>
                                        </td>
                                        <td>
                                            @if ($dv->is_active == 1)
                                                <span class="status-active">Đang hoạt động</span>
                                            @else
                                                <span class="status-inactive">Ngừng hoạt động</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="empty-state">
                                            Chưa có dữ liệu dịch vụ.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lịch sử sử dụng dịch vụ --}}
        <div class="service-table-card">
            <div class="service-table-heading">
                <div>
                    <h2>
                        <i class="bi bi-clock-history me-2"></i>
                        Lịch sử dịch vụ
                    </h2>
                    <small class="text-secondary">
                        Các dịch vụ đã được ghi nhận trong hệ thống.
                    </small>
                </div>

                <input type="search"
                       id="serviceHistorySearch"
                       class="service-search"
                       placeholder="Tìm khách, phòng, dịch vụ...">
            </div>

            <div class="service-table-wrapper">
                <table class="table service-table" id="serviceHistoryTable">
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Mã đặt phòng</th>
                            <th>Phòng</th>
                            <th>Dịch vụ</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($daSuDung as $item)
                            <tr>
                                <td>
                                    <span class="guest-name">{{ $item->guest_name }}</span>
                                </td>
                                <td>{{ $item->booking_code }}</td>
                                <td>
                                    <span class="room-badge">{{ $item->room_number }}</span>
                                </td>
                                <td>{{ $item->tenDichVu }}</td>
                                <td>{{ $item->quantity }} {{ $item->unit }}</td>
                                <td>
                                    {{ number_format($item->unit_price, 0, ',', '.') }} đ
                                </td>
                                <td>
                                    <strong class="text-success">
                                        {{ number_format($item->total_price, 0, ',', '.') }} đ
                                    </strong>
                                </td>
                                <td>
                                    @if ($item->used_at)
                                        {{ \Carbon\Carbon::parse($item->used_at)->format('d/m/Y H:i') }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Chưa có dịch vụ nào được ghi nhận.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="serviceSearchEmpty" class="empty-state" style="display:none">
                Không tìm thấy kết quả phù hợp.
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('service_id');
        const quantityInput = document.getElementById('quantity');
        const totalElement = document.getElementById('serviceTotal');
        const unitPriceElement = document.getElementById('serviceUnitPrice');

        // Tính thành tiền dự kiến ở giao diện.
        // Giá trị cuối cùng vẫn được tính lại ở Controller.
        function updateServiceTotal() {
            if (!serviceSelect || !quantityInput || !totalElement) {
                return;
            }

            const option = serviceSelect.options[serviceSelect.selectedIndex];
            const price = Number(option?.dataset?.price || 0);
            const unit = option?.dataset?.unit || '';
            const quantity = Math.max(0, Number(quantityInput.value || 0));
            const formatter = new Intl.NumberFormat('vi-VN');

            totalElement.textContent = formatter.format(price * quantity) + ' đ';

            unitPriceElement.textContent = price > 0
                ? 'Đơn giá: ' + formatter.format(price) + ' đ/' + unit
                : 'Chọn dịch vụ để xem đơn giá.';
        }

        serviceSelect?.addEventListener('change', updateServiceTotal);
        quantityInput?.addEventListener('input', updateServiceTotal);
        updateServiceTotal();

        // Tìm kiếm lịch sử dịch vụ.
        const searchInput = document.getElementById('serviceHistorySearch');
        const historyTable = document.getElementById('serviceHistoryTable');
        const emptyMessage = document.getElementById('serviceSearchEmpty');

        searchInput?.addEventListener('input', function () {
            const keyword = this.value.trim().toLocaleLowerCase('vi');
            const rows = historyTable.querySelectorAll('tbody tr');
            let visibleCount = 0;

            rows.forEach(function (row) {
                const matched = row.textContent
                    .toLocaleLowerCase('vi')
                    .includes(keyword);

                row.style.display = matched ? '' : 'none';

                if (matched) {
                    visibleCount++;
                }
            });

            emptyMessage.style.display = visibleCount === 0 ? 'block' : 'none';
        });
    });
</script>
@endpush
