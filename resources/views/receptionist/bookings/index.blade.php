
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đặt phòng | Vinpearl</title>

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

        .admin-main {
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
            margin-bottom: 8px;
        }

        .page-description {
            color: #7a8491;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .summary-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
        }

        .summary-label {
            color: #7a8491;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .summary-value {
            color: var(--navy);
            font-size: 26px;
            font-weight: 700;
        }

        .summary-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4efe4;
            color: var(--gold);
            border-radius: 10px;
            font-size: 21px;
        }

        .data-card {
            margin-top: 25px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(23, 50, 77, .03);
        }

        .data-card-header {
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            border-bottom: 1px solid var(--border);
        }

        .data-card-header h2 {
            font-size: 17px;
            font-weight: 700;
            color: var(--navy);
            margin: 0;
        }

        .record-count {
            color: #927640;
            background: #f7f2e8;
            border-radius: 20px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .table {
            margin: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f8f9fb;
            color: #647084;
            font-size: 11px;
            letter-spacing: .4px;
            font-weight: 700;
            padding: 16px;
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }

        .table tbody td {
            padding: 16px;
            font-size: 13px;
            white-space: nowrap;
            border-color: #eef0f3;
        }

        .table tbody tr:hover td {
            background: #fcfaf5;
        }

        .booking-code {
            color: var(--navy);
            font-weight: 700;
        }

        .guest-name {
            color: #344054;
            font-weight: 600;
        }

        .status-label {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #f4efe4;
            color: #927640;
            font-size: 11px;
            font-weight: 700;
        }

        .amount {
            color: var(--navy);
            font-weight: 700;
        }

        .btn-detail {
            background: var(--navy);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: .2s;
        }

        .btn-detail:hover {
            background: var(--gold);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 45px 20px !important;
            color: #7a8491;
            white-space: normal !important;
        }

        .empty-state i {
            display: block;
            font-size: 35px;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .pagination-area {
            padding: 20px 24px;
            overflow-x: auto;
        }

        .pagination-area nav {
            display: flex;
            justify-content: flex-end;
        }

        .pagination-area .page-link {
            color: var(--navy);
        }

        .pagination-area .active .page-link {
            background: var(--navy);
            border-color: var(--navy);
            color: white;
        }

        .admin-footer {
            text-align: center;
            padding: 20px;
            color: #8a929e;
            font-size: 12px;
            border-top: 1px solid var(--border);
            background: white;
        }

        @media (max-width: 576px) {
            .admin-main {
                padding-top: 25px;
            }

            .page-title {
                font-size: 24px;
            }

            .data-card-header {
                padding: 18px;
            }
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
        }

        .btn-back:hover {
            background: var(--navy);
            color: white;
        }
    </style>
</head>

<body>

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center gap-3">
        <a href="{{ url('/receptionist/dashboard') }}" class="brand">
            VINPEARL
            <span>RECEPTION MANAGEMENT</span>
        </a>

        <div class="header-label d-none d-sm-block">
            <i class="bi bi-person-badge me-2"></i>
            Hệ thống quản lý lễ tân
        </div>
    </div>
</header>

<main class="admin-main">
    <div class="container">

        <div class="breadcrumb-text">
            <i class="bi bi-house-door me-1"></i>
            Quản trị
            <span class="mx-2">/</span>
            Đặt phòng
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-2">
            <h1 class="page-title mb-0">Quản lý đặt phòng</h1>

            <a href="{{ url('/receptionist/dashboard') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Quay lại Dashboard
            </a>
        </div>
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <p class="page-description">
            Theo dõi, kiểm tra và quản lý các lượt đặt phòng của khách hàng.
        </p>

        <div class="row g-3">

            <div class="col-md-6 col-lg-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="summary-label">Số đơn trên trang hiện tại</div>
                            <div class="summary-value">{{ $datPhong->count() }}</div>
                        </div>

                        <div class="summary-icon">
                            <i class="bi bi-calendar2-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="summary-label">Tổng giá trị đơn trên trang</div>
                            <div class="summary-value" style="font-size: 20px;">
                                {{ number_format($datPhong->sum('total_amount'), 0, ',', '.') }}
                                <small style="font-size: 12px;">VNĐ</small>
                            </div>
                        </div>

                        <div class="summary-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="summary-label">Nghiệp vụ</div>
                            <div class="summary-value" style="font-size: 19px;">
                                Đặt phòng
                            </div>
                        </div>

                        <div class="summary-icon">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="data-card">

            <div class="data-card-header">
                <h2>
                    <i class="bi bi-list-ul me-2" style="color: #b49a65;"></i>
                    Danh sách lượt đặt phòng
                </h2>

                <span class="record-count">
                    {{ $datPhong->count() }} đơn trên trang
                </span>
            </div>

            <div class="table-responsive">
                <table class="table">
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
                                    <span class="guest-name">
                                        {{ $dat->guest_name }}
                                    </span>
                                </td>

                                <td>{{ $dat->guest_phone }}</td>
                                <td>{{ $dat->check_in_date }}</td>
                                <td>{{ $dat->check_out_date }}</td>
                                <td class="text-center">{{ $dat->num_adults }}</td>
                                <td class="text-center">{{ $dat->num_children }}</td>

                                <td>
                                    <span class="status-label">
                                        {{ $dat->status }}
                                    </span>
                                </td>

                                <td>
                                    <span class="amount">
                                        {{ number_format($dat->total_amount, 0, ',', '.') }} VNĐ
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="d-flex flex-column gap-2 align-items-start">

                                        <a href="{{ route('receptionist.bookings.show', $dat->id) }}"
                                        class="btn-detail">
                                            <i class="bi bi-eye"></i>
                                            Chi tiết
                                        </a>

                                        @if ($dat->status == 'pending')
                                            <form action="{{ route('receptionist.bookings.confirm', $dat->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xác nhận đơn này?');">
                                                @csrf

                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Xác nhận
                                                </button>
                                            </form>
                                        @elseif ($dat->status == 'confirmed')
                                            <span class="badge text-bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Đã xác nhận
                                            </span>
                                        @endif

                                    </div>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="empty-state">
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

            @if (method_exists($datPhong, 'links'))
                <div class="pagination-area">
                    {{ $datPhong->links() }}
                </div>
            @endif

        </div>
    </div>
</main>

<footer class="admin-footer">
    &copy; {{ date('Y') }} Vinpearl — Hệ thống quản lý đặt phòng nội bộ
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
