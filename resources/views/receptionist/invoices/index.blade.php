
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý hóa đơn | Vinpearl</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy: #17324d;
            --navy-light: #254762;
            --gold: #b49a65;
            --background: #f5f6f8;
            --border: #e7e9ed;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: #344054;
        }

        /* HEADER */
        .admin-header {
            background: var(--navy);
            color: white;
            padding: 20px 0;
            box-shadow: 0 3px 12px rgba(23, 50, 77, .12);
        }

        .brand {
            color: white;
            text-decoration: none;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .brand span {
            display: block;
            color: #d6c49b;
            font-size: 9px;
            letter-spacing: 2px;
            margin-top: 3px;
        }

        .header-label {
            font-size: 13px;
            color: #e0e6ec;
        }

        /* MAIN */
        .invoice-main {
            min-height: 65vh;
            padding: 35px 0 60px;
        }

        .breadcrumb-text {
            font-size: 13px;
            color: #858d98;
            margin-bottom: 20px;
        }

        .page-title {
            color: var(--navy);
            font-size: 29px;
            font-weight: 700;
        }

        .page-description {
            color: #7a8491;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: white;
            color: var(--navy);
            border: 1px solid var(--navy);
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
            white-space: nowrap;
        }

        .btn-back:hover {
            background: var(--navy);
            color: white;
        }

        /* CARD */
        .invoice-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
        }

        .invoice-card .card-body {
            padding: 24px;
        }

        .section-title {
            color: var(--navy);
            font-size: 17px;
            font-weight: 700;
        }

        .section-description {
            color: #7a8491;
            font-size: 13px;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4efe4;
            color: var(--gold);
            border-radius: 10px;
            font-size: 22px;
            flex-shrink: 0;
        }

        /* FORM */
        .invoice-page .form-label {
            color: #344054;
            font-size: 13px;
            font-weight: 600;
        }

        .invoice-page .form-select,
        .invoice-page .form-control {
            min-height: 43px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
        }

        .invoice-page .form-select:focus,
        .invoice-page .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 .2rem rgba(180, 154, 101, .12);
        }

        .btn-create {
            min-height: 43px;
            background: var(--navy);
            color: white;
            border: 1px solid var(--navy);
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-create:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: white;
        }

        /* TABLE */
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
            border-bottom: 1px solid var(--border);
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
            color: var(--navy);
            font-weight: 700;
        }

        .invoice-subtext {
            color: #7a8491;
            font-size: 12px;
        }

        .amount {
            color: var(--navy);
            font-weight: 700;
            white-space: nowrap;
        }

        .record-count {
            display: inline-block;
            padding: 7px 12px;
            color: #927640;
            background: #f7f2e8;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            color: var(--navy);
            background: white;
            border: 1px solid var(--navy);
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
        }

        .btn-detail:hover {
            color: white;
            background: var(--navy);
        }

        .empty-state {
            text-align: center;
            padding: 45px 20px !important;
            color: #7a8491;
            white-space: normal !important;
        }

        .empty-state i {
            display: block;
            color: var(--gold);
            font-size: 35px;
            margin-bottom: 10px;
        }

        /* FOOTER */
        .admin-footer {
            text-align: center;
            padding: 20px;
            color: #8a929e;
            font-size: 12px;
            border-top: 1px solid var(--border);
            background: white;
        }

        @media (max-width: 767px) {
            .invoice-main {
                padding: 25px 0 40px;
            }

            .page-title {
                font-size: 24px;
            }

            .invoice-card .card-body {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

    {{-- HEADER LỄ TÂN --}}
    <header class="admin-header">
        <div class="container d-flex justify-content-between align-items-center gap-3">

            <a href="{{ route('receptionist.dashboard') }}" class="brand">
                VINPEARL
                <span>RECEPTION MANAGEMENT</span>
            </a>

            <div class="header-label d-none d-sm-block">
                <i class="bi bi-person-badge me-2"></i>
                Hệ thống quản lý lễ tân
            </div>

        </div>
    </header>

    {{-- NỘI DUNG CHÍNH --}}
    <main class="invoice-main invoice-page">
        <div class="container">

            {{-- TIÊU ĐỀ --}}
            <div class="mb-4">

                <div class="breadcrumb-text">
                    <i class="bi bi-house-door me-1"></i>
                    Quản trị
                    <span class="mx-2">/</span>
                    Quản lý hóa đơn
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <h1 class="page-title mb-0">Quản lý hóa đơn</h1>

                    <a href="{{ route('receptionist.dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại Dashboard
                    </a>

                </div>

                <p class="page-description">
                    Lập hóa đơn phòng, dịch vụ và theo dõi tình trạng thanh toán.
                </p>

            </div>

            {{-- THÔNG BÁO --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}

                    <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}

                    <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Vui lòng kiểm tra lại:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif

            {{-- LẬP HÓA ĐƠN --}}
            <div class="invoice-card mb-4">

                <div class="card-body">

                    <div class="d-flex align-items-start gap-3 mb-4">

                        <div class="section-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h2 class="section-title mb-1">
                                Lập hóa đơn mới
                            </h2>

                            <p class="section-description mb-0">
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

                                <button type="submit" class="btn btn-create w-100">
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
                            <h2 class="section-title mb-1">
                                <i class="bi bi-list-ul me-2" style="color: #b49a65;"></i>
                                Danh sách hóa đơn
                            </h2>

                            <p class="section-description mb-0">
                                Theo dõi thông tin và tình trạng thanh toán của hóa đơn.
                            </p>
                        </div>

                        <span class="record-count">
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
                                                class="btn-detail">

                                                <i class="bi bi-eye"></i>
                                                Chi tiết

                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="empty-state">

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
    </main>

    {{-- FOOTER LỄ TÂN --}}
    <footer class="admin-footer">
        &copy; {{ date('Y') }} Vinpearl — Hệ thống quản lý hóa đơn nội bộ
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
