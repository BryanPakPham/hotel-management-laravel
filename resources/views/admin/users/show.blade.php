
@extends('layouts.admin')

@section('title', 'Chi tiết khách hàng')
@section('page-heading', 'Chi tiết khách hàng')

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Chi tiết khách hàng</h2>
        <p class="text-secondary mb-0">
            Thông tin tài khoản khách hàng trên hệ thống.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Mã khách hàng</div>
                    <div class="fw-semibold">KH{{ $user->id }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Họ và tên</div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Email</div>
                    <div>{{ $user->email }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Số điện thoại</div>
                    <div>{{ $user->phone ?: '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Số CCCD</div>
                    <div>{{ $user->id_number ?: '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Địa chỉ</div>
                    <div>{{ $user->address ?: '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Trạng thái tài khoản</div>

                    @if ($user->is_active)
                        <span class="badge bg-success-subtle text-success">
                            Đang hoạt động
                        </span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary">
                            Ngừng hoạt động
                        </span>
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="text-secondary small mb-1">Ngày tạo tài khoản</div>
                    <div>
                        {{ $user->created_at
                            ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i')
                            : '—' }}
                    </div>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                   class="btn btn-primary">
                    Sửa thông tin
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-outline-secondary">
                    Quay lại danh sách
                </a>
            </div>

        </div>
    </div>

@endsection
