
@extends('layouts.admin')

@section('title', 'Quản lý phòng')
@section('page-heading', 'Quản lý phòng')

@section('content')

    {{-- Thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- Thông báo lỗi --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- Tiêu đề trang --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Quản lý phòng</h2>
        <p class="text-secondary mb-0">
            Theo dõi thông tin và trạng thái phòng khách sạn
        </p>
    </div>

    {{-- Thống kê --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Tổng số phòng</div>
                <div class="fs-3 fw-bold" style="color: #12304A;">
                    {{ $totalRooms }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Phòng trống</div>
                <div class="fs-3 fw-bold text-success">
                    {{ $availableRooms }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Đang sử dụng</div>
                <div class="fs-3 fw-bold text-danger">
                    {{ $occupiedRooms }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Dọn dẹp / Bảo trì</div>
                <div class="fs-3 fw-bold text-warning">
                    {{ $otherRooms }}
                </div>
            </div>
        </div>

    </div>

    {{-- Tìm kiếm và lọc --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">

            <form action="{{ route('admin.rooms.index') }}"
                  method="GET"
                  class="row g-3">

                <div class="col-md-5">
                    <label for="keyword" class="form-label">Số phòng</label>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        class="form-control"
                        placeholder="Nhập số phòng cần tìm..."
                        value="{{ request('keyword') }}"
                    >
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Trạng thái</label>

                    <select id="status" name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>

                        <option value="available"
                            @selected(request('status') == 'available')>
                            Phòng trống
                        </option>

                        <option value="occupied"
                            @selected(request('status') == 'occupied')>
                            Đang sử dụng
                        </option>

                        <option value="cleaning"
                            @selected(request('status') == 'cleaning')>
                            Đang dọn dẹp
                        </option>

                        <option value="maintenance"
                            @selected(request('status') == 'maintenance')>
                            Đang bảo trì
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tìm kiếm
                    </button>

                    <a href="{{ route('admin.rooms.index') }}"
                       class="btn btn-outline-secondary">
                        Làm mới
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- Tiêu đề danh sách và nút thêm phòng --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h4 class="mb-1">Danh sách phòng</h4>
            <p class="text-muted mb-0">
                Quản lý thông tin và trạng thái hoạt động của phòng.
            </p>
        </div>

        <a href="{{ route('admin.rooms.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Thêm phòng
        </a>

    </div>

    {{-- Bảng danh sách phòng --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Số phòng</th>
                            <th>Loại phòng</th>
                            <th>Tầng</th>
                            <th>Giá cơ bản / đêm</th>
                            <th>Trạng thái</th>
                            <th>Ghi chú</th>
                            <th class="text-center" style="min-width: 150px;">
                                Thao tác
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($rooms as $room)
                            <tr>
                                {{-- STT --}}
                                <td>
                                    {{ $rooms->firstItem() + $loop->index }}
                                </td>

                                {{-- Số phòng --}}
                                <td class="fw-bold">
                                    {{ $room->room_number }}
                                </td>

                                {{-- Loại phòng --}}
                                <td>
                                    {{ $room->room_type_name }}
                                </td>

                                {{-- Tầng --}}
                                <td>
                                    {{ $room->floor }}
                                </td>

                                {{-- Giá phòng --}}
                                <td class="text-nowrap">
                                    {{ number_format($room->base_price, 0, ',', '.') }} đ
                                </td>

                                {{-- Trạng thái --}}
                                <td>
                                    @if ($room->status == 'available')
                                        <span class="badge bg-success-subtle text-success">
                                            Phòng trống
                                        </span>
                                    @elseif ($room->status == 'occupied')
                                        <span class="badge bg-danger-subtle text-danger">
                                            Đang sử dụng
                                        </span>
                                    @elseif ($room->status == 'cleaning')
                                        <span class="badge bg-warning-subtle text-warning-emphasis">
                                            Đang dọn dẹp
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Đang bảo trì
                                        </span>
                                    @endif
                                </td>

                                {{-- Ghi chú --}}
                                <td>
                                    {{ $room->note ?: '—' }}
                                </td>

                                {{-- Thao tác --}}
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <a
                                            href="{{ route('admin.rooms.edit', $room->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Sửa thông tin phòng"
                                        >
                                            Sửa
                                        </a>

                                        <form
                                            action="{{ route('admin.rooms.destroy', $room->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng {{ $room->room_number }} không?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Xóa phòng"
                                            >
                                                Xóa
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center text-secondary py-4">
                                    Không tìm thấy phòng phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Thông tin và phân trang --}}
            <div class="d-flex justify-content-between align-items-center mt-4">

                <div class="text-secondary small">
                    @if ($rooms->total() > 0)
                        Hiển thị {{ $rooms->firstItem() }}
                        - {{ $rooms->lastItem() }}
                        trong tổng số {{ $rooms->total() }} phòng
                    @else
                        Không có phòng nào.
                    @endif
                </div>

                <div class="ms-auto">
                    {{ $rooms->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>
    </div>

@endsection
