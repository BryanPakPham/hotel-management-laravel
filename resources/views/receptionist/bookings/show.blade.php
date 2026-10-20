
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đặt phòng | Vinpearl</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy: #17324d;
            --gold: #b49a65;
            --background: #f5f6f8;
            --border: #e7e9ed;
        }

        body {
            margin: 0;
            background: var(--background);
            color: #344054;
            font-family: "Segoe UI", Arial, sans-serif;
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
            color: #e0e6ec;
            font-size: 13px;
        }

        .detail-main {
            padding: 35px 0 60px;
        }

        .breadcrumb-text {
            font-size: 13px;
            color: #858d98;
            margin-bottom: 20px;
        }

        .breadcrumb-text a {
            color: #927640;
            text-decoration: none;
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

        .detail-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(23, 50, 77, .04);
        }

        .detail-card-header {
            padding: 25px 28px;
            background: var(--navy);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .detail-card-header h2 {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .booking-code {
            font-size: 13px;
            color: #d6c49b;
        }

        .status-label {
            display: inline-block;
            background: #f4efe4;
            color: #80652e;
            border-radius: 20px;
            padding: 8px 13px;
            font-size: 12px;
            font-weight: 700;
        }

        .detail-card-body {
            padding: 28px;
        }

        .section-title {
            color: var(--navy);
            font-size: 16px;
            font-weight: 700;
            padding-bottom: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        .section-title i {
            color: var(--gold);
            margin-right: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            padding: 15px 0;
            border-bottom: 1px solid #eef0f3;
        }

        .info-label {
            color: #7a8491;
            font-size: 13px;
        }

        .info-value {
            color: #344054;
            font-size: 13px;
            font-weight: 600;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .price-box {
            margin-top: 28px;
            padding: 22px;
            border: 1px solid #e9e0ce;
            background: #f8f5ed;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .price-label {
            color: #667085;
            font-size: 13px;
        }

        .price-value {
            color: #927640;
            font-size: 25px;
            font-weight: 800;
            text-align: right;
        }

        .detail-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 17px;
            border: 1px solid var(--navy);
            border-radius: 6px;
            background: var(--navy);
            color: white;
            text-decoration: none;
            font-size: 13px;
            transition: .2s;
        }

        .btn-back:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: white;
        }

        .internal-note {
            color: #8a929e;
            font-size: 12px;
            margin-top: 20px;
            margin-bottom: 0;
        }

        .admin-footer {
            text-align: center;
            padding: 20px;
            color: #8a929e;
            font-size: 12px;
            background: white;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 576px) {
            .detail-main {
                padding-top: 25px;
            }

            .page-title {
                font-size: 24px;
            }

            .detail-card-header,
            .detail-card-body {
                padding: 20px;
            }

            .price-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .price-value {
                text-align: left;
                font-size: 22px;
            }
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

<main class="detail-main">
    <div class="container">

        <div class="breadcrumb-text">
            <i class="bi bi-house-door me-1"></i>
            <a href="{{ url('/receptionist/dashboard') }}">Quản trị</a>

            <span class="mx-2">/</span>

            <a href="{{ url('/test-bookings') }}">Danh sách đặt phòng</a>

            <span class="mx-2">/</span>
            Chi tiết
        </div>

        <h1 class="page-title">Chi tiết đặt phòng</h1>

        <p class="page-description">
            Kiểm tra thông tin khách hàng và lịch trình để phục vụ công tác lễ tân.
        </p>

        <div class="detail-card">

            <div class="detail-card-header">
                <div>
                    <h2>
                        <i class="bi bi-calendar2-check me-2"></i>
                        Thông tin lượt đặt phòng
                    </h2>

                    <div class="booking-code">
                        Mã đặt phòng: {{ $dat->booking_code }}
                    </div>
                </div>

                <span class="status-label">
                    {{ $dat->status }}
                </span>
            </div>

            <div class="detail-card-body">

                <div class="row g-4">

                    <div class="col-lg-6">
                        <h3 class="section-title">
                            <i class="bi bi-person-vcard"></i>
                            Thông tin khách hàng
                        </h3>

                        <div class="info-row">
                            <span class="info-label">Họ và tên</span>
                            <span class="info-value">{{ $dat->guest_name }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Số điện thoại</span>
                            <span class="info-value">{{ $dat->guest_phone }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Tài khoản đặt phòng</span>
                            <span class="info-value">
                                {{ $dat->tenTaiKhoan ?? 'Khách vãng lai' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h3 class="section-title">
                            <i class="bi bi-calendar-week"></i>
                            Thông tin lưu trú
                        </h3>

                        <div class="info-row">
                            <span class="info-label">Ngày nhận phòng</span>
                            <span class="info-value">{{ $dat->check_in_date }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Ngày trả phòng</span>
                            <span class="info-value">{{ $dat->check_out_date }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Số người lớn</span>
                            <span class="info-value">{{ $dat->num_adults }} người</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Số trẻ em</span>
                            <span class="info-value">{{ $dat->num_children }} trẻ</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Trạng thái hiện tại</span>
                            <span class="info-value">{{ $dat->status }}</span>
                        </div>
                    </div>

                </div>

                <div class="price-box">
                    <div>
                        <div class="price-label">
                            <i class="bi bi-wallet2 me-2"></i>
                            Tổng giá trị đơn đặt phòng
                        </div>

                        <small class="text-secondary">
                            Theo dữ liệu hiện tại trong hệ thống
                        </small>
                    </div>

                    <div class="price-value">
                        {{ number_format($dat->total_amount, 0, ',', '.') }} VNĐ
                    </div>
                </div>

                <div class="detail-actions">
                    <a href="{{ url('/test-bookings') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại danh sách
                    </a>
                </div>

                <p class="internal-note">
                    Giao diện quản lý nội bộ dành cho nhân viên lễ tân.
                </p>

            </div>
        </div>

    </div>
</main>

<footer class="admin-footer">
    &copy; {{ date('Y') }} Vinpearl — Hệ thống quản lý đặt phòng nội bộ
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
