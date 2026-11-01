
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý lưu trú | Vinpearl</title>

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
        .stay-main {
            padding: 35px 0 60px;
            min-height: 65vh;
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

        /* SUMMARY */
        .summary-card {
            height: 100%;
            padding: 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
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

        /* DATA CARD */
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

        .card-subtitle {
            color: #7a8491;
            font-size: 12px;
            margin-top: 5px;
        }

        .record-count {
            color: #927640;
            background: #f7f2e8;
            border-radius: 20px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .stay-filter {
            width: 280px;
            max-width: 100%;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 9px 12px;
            font-size: 13px;
        }

        .stay-filter:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 .2rem rgba(180, 154, 101, .12);
        }

        /* TABLE */
        .stay-table {
            margin: 0;
            vertical-align: middle;
        }

        .stay-table thead th {
            background: #f8f9fb;
            color: #647084;
            font-size: 11px;
            letter-spacing: .4px;
            font-weight: 700;
            padding: 16px;
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }

        .stay-table tbody td {
            padding: 16px;
            font-size: 13px;
            white-space: nowrap;
            border-color: #eef0f3;
        }

        .stay-table tbody tr:hover td {
            background: #fcfaf5;
        }

        .stay-code {
            color: var(--navy);
            font-weight: 700;
        }

        .guest-name {
            color: #344054;
            font-weight: 600;
        }

        .stay-muted {
            color: #7a8491;
            font-size: 12px;
        }

        /* STATUS */
        .status-label {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-confirmed {
            color: #927640;
            background: #f4efe4;
        }

        .status-checked-in {
            color: #0f6848;
            background: #d8f3e7;
        }

        .status-checked-out {
            color: #495057;
            background: #e9ecef;
        }

        .status-other {
            color: #0d6efd;
            background: #e7f1ff;
        }

        /* ACTION BUTTONS */
        .btn-stay {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            transition: .2s;
        }

        .btn-check-in {
            color: white;
            background: var(--navy);
            border: 1px solid var(--navy);
        }

        .btn-check-in:hover {
            color: white;
            background: var(--gold);
            border-color: var(--gold);
        }

        .btn-check-out {
            color: white;
            background: var(--gold);
            border: 1px solid var(--gold);
        }

        .btn-check-out:hover {
            color: white;
            background: #927640;
            border-color: #927640;
        }

        /* EMPTY */
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
            border-top: 1px solid var(--border);
            color: #8a929e;
            font-size: 12px;
        }

        /* MODAL */
        .stay-modal .modal-content {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .stay-modal .modal-header {
            padding: 20px 24px;
            color: white;
            background: var(--navy);
        }

        .stay-modal .modal-title {
            font-size: 17px;
            font-weight: 700;
        }

        .stay-modal .modal-body {
            padding: 24px;
        }

        .stay-modal .form-label {
            color: #344054;
            font-size: 13px;
            font-weight: 600;
        }

        .stay-modal .form-control,
        .stay-modal .form-select {
            font-size: 13px;
            border-color: var(--border);
            border-radius: 6px;
            padding: 10px 12px;
        }

        .stay-modal .form-control:focus,
        .stay-modal .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 .2rem rgba(180, 154, 101, .12);
        }

        .stay-modal .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
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
            .stay-main {
                padding-top: 25px;
            }

            .page-title {
                font-size: 24px;
            }

            .data-card-header {
                padding: 18px;
            }

            .stay-filter {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- HEADER LỄ TÂN --}}
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

    {{-- NỘI DUNG CHÍNH --}}
    <main class="stay-main">
        <div class="container">

            {{-- Tiêu đề --}}
            <div class="mb-4">
                <div class="breadcrumb-text">
                    <i class="bi bi-house-door me-1"></i>
                    Quản trị
                    <span class="mx-2">/</span>
                    Quản lý lưu trú
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h1 class="page-title mb-0">Quản lý lưu trú</h1>

                    <a href="{{ url('/receptionist/dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại Dashboard
                    </a>
                </div>

                <p class="page-description">
                    Theo dõi, kiểm tra và thực hiện thủ tục nhận phòng, trả phòng của khách hàng.
                </p>
            </div>

            {{-- THÔNG BÁO --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- THỐNG KÊ --}}
            @php
                $tongDatPhong = $datPhong->count();

                $choNhanPhong = $datPhong->filter(function ($item) {
                    return $item->stay_id == null;
                })->count();

                $dangLuuTru = $datPhong->filter(function ($item) {
                    return $item->stay_id != null && $item->actual_check_out == null;
                })->count();
            @endphp

            <div class="row g-3">

                <div class="col-md-6 col-lg-4">
                    <div class="summary-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-label">Tổng lượt đặt phòng</div>
                                <div class="summary-value">{{ $tongDatPhong }}</div>
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
                                <div class="summary-label">Chờ nhận phòng</div>
                                <div class="summary-value">{{ $choNhanPhong }}</div>
                            </div>

                            <div class="summary-icon">
                                <i class="bi bi-box-arrow-in-right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="summary-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-label">Đang lưu trú</div>
                                <div class="summary-value">{{ $dangLuuTru }}</div>
                            </div>

                            <div class="summary-icon">
                                <i class="bi bi-house-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- DANH SÁCH LƯU TRÚ --}}
            <div class="data-card">

                <div class="data-card-header">
                    <div>
                        <h2>
                            <i class="bi bi-list-ul me-2" style="color: #b49a65;"></i>
                            Danh sách phòng lưu trú
                        </h2>

                        <div class="card-subtitle">
                            Quản lý trạng thái nhận phòng và trả phòng
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="record-count">
                            {{ $tongDatPhong }} lượt đặt phòng
                        </span>

                        <input type="text" id="staySearch"
                            class="form-control stay-filter"
                            placeholder="Tìm mã đặt phòng, khách, số phòng..."
                            aria-label="Tìm kiếm lưu trú">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table stay-table" id="stayTable">
                        <thead>
                            <tr>
                                <th>MÃ ĐẶT PHÒNG</th>
                                <th>KHÁCH HÀNG</th>
                                <th>LOẠI PHÒNG</th>
                                <th>SỐ PHÒNG</th>
                                <th>THỜI GIAN</th>
                                <th>TRẠNG THÁI</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($datPhong as $item)
                                <tr>
                                    <td>
                                        <span class="stay-code">
                                            {{ $item->booking_code }}
                                        </span>

                                        <div class="stay-muted">
                                            Chi tiết #{{ $item->booking_room_id }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="guest-name">
                                            {{ $item->guest_name }}
                                        </span>

                                        <div class="stay-muted">
                                            {{ $item->guest_phone }}
                                        </div>

                                        @if($item->tenTaiKhoan)
                                            <div class="stay-muted">
                                                Tài khoản: {{ $item->tenTaiKhoan }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{ $item->room_type_name }}</td>

                                    <td>
                                        @if($item->room_number)
                                            <span class="fw-semibold">
                                                {{ $item->room_number }}
                                            </span>
                                        @else
                                            <span class="text-muted">Chưa xếp phòng</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div>
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ $item->check_in_date }}
                                        </div>

                                        <div class="stay-muted mt-1">
                                            <i class="bi bi-calendar2-check me-1"></i>
                                            {{ $item->check_out_date }}
                                        </div>
                                    </td>

                                    <td>
                                        @if($item->actual_check_out != null)
                                            <span class="status-label status-checked-out">
                                                Đã trả phòng
                                            </span>
                                        @elseif($item->stay_id != null)
                                            <span class="status-label status-checked-in">
                                                Đang lưu trú
                                            </span>
                                        @elseif($item->booking_status == 'confirmed')
                                            <span class="status-label status-confirmed">
                                                Chờ nhận phòng
                                            </span>
                                        @else
                                            <span class="status-label status-other">
                                                {{ $item->booking_status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->stay_id == null)
                                            <button type="button"
                                                class="btn btn-stay btn-check-in"
                                                data-bs-toggle="modal"
                                                data-bs-target="#checkInModal"
                                                data-booking-room-id="{{ $item->booking_room_id }}"
                                                data-guest-name="{{ $item->guest_name }}"
                                                data-room-type="{{ $item->room_type_name }}">

                                                <i class="bi bi-box-arrow-in-right"></i>
                                                Nhận phòng
                                            </button>

                                        @elseif($item->actual_check_out == null)
                                            <form method="POST"
                                                action="{{ route('receptionist.stays.checkOut', $item->stay_id) }}"
                                                onsubmit="return confirm('Xác nhận trả phòng này?');">

                                                @csrf

                                                <button type="submit"
                                                    class="btn btn-stay btn-check-out">
                                                    <i class="bi bi-box-arrow-right"></i>
                                                    Trả phòng
                                                </button>
                                            </form>

                                        @else
                                            <span class="text-muted small">Hoàn tất</span>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="bi bi-calendar-x"></i>

                                        <strong class="d-block mb-2">
                                            Chưa có dữ liệu lưu trú
                                        </strong>

                                        <span>
                                            Các đặt phòng đã xác nhận sẽ xuất hiện tại đây.
                                        </span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-area">
                    Hiển thị {{ $datPhong->count() }} dòng dữ liệu.
                </div>

            </div>
        </div>
    </main>

    {{-- MODAL NHẬN PHÒNG --}}
    <div class="modal fade stay-modal" id="checkInModal" tabindex="-1"
        aria-labelledby="checkInModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" id="checkInForm">
                    @csrf

                    <div class="modal-header">
                        <h2 class="modal-title" id="checkInModalLabel">
                            <i class="bi bi-door-open me-2"></i>
                            Thực hiện nhận phòng
                        </h2>

                        <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted small mb-4">
                            Vui lòng kiểm tra thông tin và chọn phòng phù hợp.
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Khách hàng</label>

                            <input type="text" id="checkInGuest"
                                class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại phòng đã đặt</label>

                            <input type="text" id="checkInRoomType"
                                class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="room_id" class="form-label">
                                Chọn phòng trống <span class="text-danger">*</span>
                            </label>

                            <select name="room_id" id="room_id"
                                class="form-select" required>

                                <option value="">-- Chọn phòng --</option>

                                @foreach($phongTrong as $phong)
                                    <option value="{{ $phong->id }}"
                                        data-room-type-id="{{ $phong->room_type_id }}">
                                        Phòng {{ $phong->room_number }}
                                    </option>
                                @endforeach
                            </select>

                            @if($phongTrong->isEmpty())
                                <div class="form-text text-danger">
                                    Hiện không có phòng trống.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">
                            Hủy
                        </button>

                        <button type="submit" class="btn btn-stay btn-check-in"
                            {{ $phongTrong->isEmpty() ? 'disabled' : '' }}>
                            <i class="bi bi-check-circle"></i>
                            Xác nhận nhận phòng
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="admin-footer">
        &copy; {{ date('Y') }} Vinpearl — Hệ thống quản lý lưu trú nội bộ
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Tìm kiếm trong danh sách lưu trú
        document.getElementById('staySearch').addEventListener('input', function () {
            var tuKhoa = this.value.toLowerCase().trim();
            var cacDong = document.querySelectorAll('#stayTable tbody tr');

            cacDong.forEach(function (dong) {
                var noiDung = dong.textContent.toLowerCase();
                dong.style.display = noiDung.includes(tuKhoa) ? '' : 'none';
            });
        });

        // Chuẩn bị thông tin cho modal nhận phòng
        var checkInModal = document.getElementById('checkInModal');

        checkInModal.addEventListener('show.bs.modal', function (event) {
            var nut = event.relatedTarget;

            var bookingRoomId = nut.getAttribute('data-booking-room-id');
            var guestName = nut.getAttribute('data-guest-name');
            var roomType = nut.getAttribute('data-room-type');

            document.getElementById('checkInGuest').value = guestName;
            document.getElementById('checkInRoomType').value = roomType;

            document.getElementById('checkInForm').action =
                '/receptionist/stays/' + bookingRoomId + '/check-in';
        });
    </script>

</body>
</html>
