
@extends('layouts.admin')

@section('title', 'Quản lý loại phòng')
@section('page-heading', 'Quản lý loại phòng')

@section('content')
<div class="container-fluid">

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tiêu đề và nút thêm --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Danh sách loại phòng</h4>
            <p class="text-muted mb-0">
                Quản lý loại phòng, giá và sức chứa.
            </p>
        </div>

        <a href="{{ route('admin.room-types.create') }}"
           class="btn btn-primary">
            + Thêm loại phòng
        </a>
    </div>

    {{-- Tìm kiếm --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('admin.room-types.index') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-8">
                    <label for="keyword" class="form-label">
                        Tên loại phòng
                    </label>
                    <input type="text"
                           name="keyword"
                           id="keyword"
                           class="form-control"
                           value="{{ request('keyword') }}"
                           placeholder="Nhập tên loại phòng cần tìm...">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tìm kiếm
                    </button>
                    <a href="{{ route('admin.room-types.index') }}"
                       class="btn btn-outline-secondary">
                        Làm mới
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên loại phòng</th>
                            <th>Giá cơ bản</th>
                            <th>Sức chứa</th>
                            <th>Loại giường</th>
                            <th>Diện tích</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($roomTypes as $roomType)
                            <tr>
                                <td>
                                    {{ $roomTypes->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $roomType->name }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $roomType->slug }}
                                    </small>
                                </td>

                                <td class="text-nowrap">
                                    {{ number_format($roomType->base_price, 0, ',', '.') }}
                                    VNĐ
                                </td>

                                <td>
                                    {{ $roomType->max_adults }} người lớn
                                    <br>
                                    <small class="text-muted">
                                        {{ $roomType->max_children }} trẻ em
                                    </small>
                                </td>

                                <td>{{ $roomType->bed_type }}</td>

                                <td>{{ $roomType->area }} m²</td>

                                <td class="text-center text-nowrap">
                                    <a href="{{ route('admin.room-types.edit', $roomType->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Sửa
                                    </a>

                                    <form action="{{ route('admin.room-types.destroy', $roomType->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa loại phòng này không?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="text-center py-5 text-muted">
                                    Chưa có loại phòng nào.
                                    <br>
                                    Hãy nhấn “Thêm loại phòng” để tạo mới.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            @if ($roomTypes->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $roomTypes->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
