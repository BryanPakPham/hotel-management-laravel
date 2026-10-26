
@extends('layouts.admin')

@section('title', 'Quản lý dịch vụ')
@section('page-heading', 'Quản lý dịch vụ')

@section('content')
    <div class="container-fluid px-0">

        {{-- Tiêu đề và nút thêm --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Danh sách dịch vụ</h4>
                <p class="text-secondary mb-0">
                    Quản lý các dịch vụ của khách sạn.
                </p>
            </div>

            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                + Thêm dịch vụ
            </a>
        </div>

        {{-- Thông báo thành công --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Bảng dịch vụ --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">ID</th>
                                <th>Tên dịch vụ</th>
                                <th>Giá</th>
                                <th>Đơn vị tính</th>
                                <th>Mô tả</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center" style="width: 180px;">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($services as $service)
                                <tr>
                                    <td class="ps-4">{{ $service->id }}</td>

                                    <td class="fw-semibold">
                                        {{ $service->name }}
                                    </td>

                                    <td>
                                        {{ number_format($service->price, 0, ',', '.') }} đ
                                    </td>

                                    <td>
                                        {{ $service->unit ?: '—' }}
                                    </td>

                                    <td>
                                        {{ $service->description ?: 'Chưa có mô tả' }}
                                    </td>

                                    <td class="text-center">
                                        @if ($service->is_active)
                                            <span class="badge bg-success">
                                                Đang hoạt động
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Ngừng hoạt động
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Nút sửa và xóa --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.services.edit', $service->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Sửa
                                            </a>

                                            <form action="{{ route('admin.services.destroy', $service->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa dịch vụ này không?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-secondary mb-3">
                                            Chưa có dịch vụ nào.
                                        </div>

                                        <a href="{{ route('admin.services.create') }}"
                                            class="btn btn-sm btn-primary">
                                            Thêm dịch vụ đầu tiên
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Phân trang --}}
            @if ($services->hasPages())
                <div class="card-footer bg-white">
                    {{ $services->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
