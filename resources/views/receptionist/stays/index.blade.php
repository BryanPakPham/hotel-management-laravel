@extends('layouts.customer')

@section('title', 'Quản lý lưu trú | Vinpearl')

@push('styles')
<style>
    .stay-page {
        padding: 50px 0 70px;
        background: #f7f8fa;
        min-height: 60vh;
    }

    .stay-heading {
        margin-bottom: 28px;
    }

    .stay-eyebrow {
        color: #b18a4a;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .stay-title {
        color: #173b35;
        font-size: clamp(26px, 3vw, 36px);
        font-weight: 700;
        margin: 8px 0;
    }

    .stay-subtitle {
        color: #6c757d;
        margin-bottom: 0;
    }

    .stay-stat {
        height: 100%;
        padding: 22px;
        border: 1px solid #e8ebef;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .035);
    }

    .stay-stat-label {
        color: #6c757d;
        font-size: 14px;
    }

    .stay-stat-number {
        color: #173b35;
        font-size: 30px;
        font-weight: 700;
        margin-top: 8px;
    }

    .stay-card {
        background: #fff;
        border: 1px solid #e8ebef;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .035);
    }

    .stay-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e8ebef;
    }

    .stay-card-title {
        color: #173b35;
        font-size: 19px;
        font-weight: 700;
        margin: 0;
    }

    .stay-table th {
        background: #f5f7f7;
        color: #53615e;
        font-size: 12px;
        text-transform: uppercase;
        white-space: nowrap;
        padding: 15px;
    }

    .stay-table td {
        padding: 16px 15px;
        vertical-align: middle;
        font-size: 14px;
    }

    .stay-table tbody tr:hover {
        background: #fafcfb;
    }

    .stay-code {
        color: #173b35;
        font-weight: 700;
    }

    .stay-muted {
        color: #7b8583;
        font-size: 12px;
    }

    .stay-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .stay-badge--confirmed {
        color: #856404;
        background: #fff3cd;
    }

    .stay-badge--checked-in {
        color: #0f6848;
        background: #d8f3e7;
    }

    .stay-badge--checked-out {
        color: #495057;
        background: #e9ecef;
    }

    .stay-badge--occupied {
        color: #0f6848;
        background: #d8f3e7;
    }

    .stay-badge--available {
        color: #0d6efd;
        background: #e7f1ff;
    }

    .stay-badge--cleaning {
        color: #9a6700;
        background: #fff0c2;
    }

    .stay-btn {
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 12px;
        white-space: nowrap;
    }

    .stay-btn-primary {
        color: #fff;
        background: #173b35;
        border: 1px solid #173b35;
    }

    .stay-btn-primary:hover {
        color: #fff;
        background: #24574d;
    }

    .stay-btn-warning {
        color: #fff;
        background: #b18a4a;
        border: 1px solid #b18a4a;
    }

    .stay-btn-warning:hover {
        color: #fff;
        background: #96723a;
    }

    .stay-empty {
        padding: 45px 20px;
        text-align: center;
        color: #7b8583;
    }

    .stay-empty i {
        display: block;
        font-size: 34px;
        margin-bottom: 12px;
        color: #b18a4a;
    }

    .stay-filter {
        max-width: 280px;
    }

    @media (max-width: 767px) {
        .stay-page {
            padding: 30px 0 45px;
        }

        .stay-card-header {
            padding: 18px;
        }

        .stay-filter {
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<section class="stay-page">
    <div class="container">

        {{-- Tiêu đề --}}
        <div class="stay-heading">
            <span class="stay-eyebrow">VINPEARL · RECEPTION</span>
            <h1 class="stay-title">Quản lý lưu trú</h1>
            <p class="stay-subtitle">
                Theo dõi đặt phòng, thực hiện thủ tục nhận phòng và trả phòng.
            </p>
        </div>

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Đóng"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Đóng"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Thống kê --}}
        @php
            $tongDatPhong = $datPhong->count();
            $choNhanPhong = $datPhong->filter(function ($item) {
                return $item->stay_id == null;
            })->count();
            $dangLuuTru = $datPhong->filter(function ($item) {
                return $item->stay_id != null && $item->actual_check_out == null;
            })->count();
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="stay-stat">
                    <div class="stay-stat-label">
                        <i class="bi bi-journal-check me-2"></i>Tổng lượt đặt phòng
                    </div>
                    <div class="stay-stat-number">{{ $tongDatPhong }}</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="stay-stat">
                    <div class="stay-stat-label">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Chờ nhận phòng
                    </div>
                    <div class="stay-stat-number">{{ $choNhanPhong }}</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="stay-stat">
                    <div class="stay-stat-label">
                        <i class="bi bi-house-check me-2"></i>Đang lưu trú
                    </div>
                    <div class="stay-stat-number">{{ $dangLuuTru }}</div>
                </div>
            </div>
        </div>

        {{-- Danh sách lưu trú --}}
        <div class="stay-card">
            <div class="stay-card-header">
                <div class="d-flex flex-column flex-md-row justify-content-between
                    align-items-md-center gap-3">
                    <div>
                        <h2 class="stay-card-title">Danh sách phòng lưu trú</h2>
                        <div class="stay-muted mt-1">
                            Quản lý trạng thái nhận phòng và trả phòng
                        </div>
                    </div>

                    <input type="text" id="staySearch"
                        class="form-control stay-filter"
                        placeholder="Tìm mã đặt phòng, khách, số phòng..."
                        aria-label="Tìm kiếm lưu trú">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table stay-table mb-0" id="stayTable">
                    <thead>
                        <tr>
                            <th>Mã đặt phòng</th>
                            <th>Khách hàng</th>
                            <th>Loại phòng</th>
                            <th>Số phòng</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
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
                                    <div class="fw-semibold">
                                        {{ $item->guest_name }}
                                    </div>
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
                                        <span class="stay-badge stay-badge--checked-out">
                                            Đã trả phòng
                                        </span>
                                    @elseif($item->stay_id != null)
                                        <span class="stay-badge stay-badge--checked-in">
                                            Đang lưu trú
                                        </span>
                                    @elseif($item->booking_status == 'confirmed')
                                        <span class="stay-badge stay-badge--confirmed">
                                            Chờ nhận phòng
                                        </span>
                                    @else
                                        <span class="stay-badge stay-badge--available">
                                            {{ $item->booking_status }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($item->stay_id == null)
                                        <button type="button"
                                            class="btn stay-btn stay-btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#checkInModal"
                                            data-booking-room-id="{{ $item->booking_room_id }}"
                                            data-guest-name="{{ $item->guest_name }}"
                                            data-room-type="{{ $item->room_type_name }}">
                                            <i class="bi bi-box-arrow-in-right me-1"></i>
                                            Nhận phòng
                                        </button>
                                    @elseif($item->actual_check_out == null)
                                        <form method="POST"
                                            action="{{ route('receptionist.stays.checkOut', $item->stay_id) }}"
                                            onsubmit="return confirm('Xác nhận trả phòng này?');">
                                            @csrf
                                            <button type="submit"
                                                class="btn stay-btn stay-btn-warning">
                                                <i class="bi bi-box-arrow-right me-1"></i>
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
                                <td colspan="7">
                                    <div class="stay-empty">
                                        <i class="bi bi-calendar2-x"></i>
                                        <div class="fw-semibold">Chưa có dữ liệu lưu trú</div>
                                        <div class="small mt-1">
                                            Các đặt phòng đã xác nhận sẽ xuất hiện tại đây.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-top text-muted small">
                Hiển thị {{ $datPhong->count() }} dòng dữ liệu.
            </div>
        </div>
    </div>
</section>

{{-- Modal nhận phòng --}}
<div class="modal fade" id="checkInModal" tabindex="-1"
    aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <form method="POST" id="checkInForm">
                @csrf

                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="checkInModalLabel">
                        <i class="bi bi-door-open me-2"></i>Thực hiện nhận phòng
                    </h2>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small">
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
                    <button type="submit" class="btn stay-btn stay-btn-primary"
                        {{ $phongTrong->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-check-circle me-1"></i>
                        Xác nhận nhận phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush