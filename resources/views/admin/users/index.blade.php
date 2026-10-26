@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')
@section('page-heading', 'Quản lý khách hàng')

@section('content')

    {{-- Thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- Thông báo lỗi --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- Tiêu đề trang --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Quản lý khách hàng</h2>
            <p class="text-muted mb-0">
                Quản lý thông tin và tài khoản khách hàng.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>
            Thêm khách hàng
        </a>
    </div>

    {{-- Thống kê khách hàng --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Tổng khách hàng</div>
                <div class="fs-3 fw-bold" style="color: #12304A;">
                    {{ $totalCustomers }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Tài khoản đang hoạt động</div>
                <div class="fs-3 fw-bold text-success">
                    {{ $activeCustomers }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-secondary">Tài khoản ngừng hoạt động</div>
                <div class="fs-3 fw-bold text-secondary">
                    {{ $inactiveCustomers }}
                </div>
            </div>
        </div>

    </div>

    {{-- Tìm kiếm và lọc khách hàng --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">

            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">

                <div class="col-md-6">
                    <label for="keyword" class="form-label">
                        Tìm khách hàng
                    </label>

                    <input type="text" id="keyword" name="keyword" class="form-control"
                        placeholder="Nhập tên, email hoặc số điện thoại..." value="{{ request('keyword') }}">
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">
                        Trạng thái tài khoản
                    </label>

                    <select id="status" name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>

                        <option value="1" @selected(request('status') === '1')>
                            Đang hoạt động
                        </option>

                        <option value="0" @selected(request('status') === '0')>
                            Ngừng hoạt động
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tìm kiếm
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        Làm mới
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- Tiêu đề danh sách --}}
    <div class="mb-4">
        <h4 class="mb-1">Danh sách khách hàng</h4>
        <p class="text-muted mb-0">
            Thông tin tài khoản khách hàng đã đăng ký trên hệ thống.
        </p>
    </div>

    {{-- Bảng danh sách khách hàng --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Số CCCD</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                {{-- STT --}}
                                <td>
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                {{-- Họ và tên --}}
                                <td class="fw-semibold">
                                    {{ $user->name }}
                                </td>

                                {{-- Email --}}
                                <td>
                                    {{ $user->email }}
                                </td>

                                {{-- Số điện thoại --}}
                                <td>
                                    {{ $user->phone ?: '—' }}
                                </td>

                                {{-- Số CCCD --}}
                                <td>
                                    {{ $user->id_number ?: '—' }}
                                </td>

                                {{-- Trạng thái --}}
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge bg-success-subtle text-success">
                                            Đang hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Ngừng hoạt động
                                        </span>
                                    @endif
                                </td>

                                {{-- Thao tác --}}

                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Xem chi tiết --}}
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                            Xem
                                        </a>

                                        {{-- Sửa thông tin --}}
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Sửa thông tin khách hàng">
                                            Sửa
                                        </a>

                                        {{-- Xóa khách hàng --}}
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng {{ $user->name }} không?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Xóa khách hàng">
                                                Xóa
                                            </button>
                                        </form>

                                    </div>
                                </td>


                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">
                                    Không tìm thấy khách hàng phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Thông tin và phân trang --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

                <div class="text-secondary small">
                    @if ($users->total() > 0)
                        Hiển thị {{ $users->firstItem() }}
                        - {{ $users->lastItem() }}
                        trong tổng số {{ $users->total() }} khách hàng
                    @else
                        Không có khách hàng nào.
                    @endif
                </div>

                <div class="ms-auto">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>
    </div>

@endsection
