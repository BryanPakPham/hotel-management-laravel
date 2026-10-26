@extends('layouts.admin')

@section('title', 'Quản lý tiện nghi')
@section('page-heading', 'Quản lý tiện nghi')

@section('content')
    <div class="container-fluid px-0">

        {{-- Tiêu đề và nút thêm --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Danh sách tiện nghi</h4>
                <p class="text-secondary mb-0">
                    Quản lý các tiện nghi của khách sạn.
                </p>
            </div>

            <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary">
                + Thêm tiện nghi
            </a>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Bảng tiện nghi --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">ID</th>
                                <th>Tên tiện nghi</th>
                                <th>Mô tả</th>
                                <th class="text-center" style="width: 180px;">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($amenities as $amenity)
                                <tr>
                                    <td class="ps-4">{{ $amenity->id }}</td>

                                  
                                    <td class="fw-semibold">
                                        {{ $amenity->name }}
                                    </td>

                                    <td>
                                        {{ $amenity->description ?: 'Chưa có mô tả' }}
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.amenities.edit', $amenity->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Sửa
                                            </a>

                                            <form action="{{ route('admin.amenities.destroy', $amenity->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa tiện nghi này không?')">
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
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-secondary mb-2">
                                            Chưa có tiện nghi nào.
                                        </div>

                                        <a href="{{ route('admin.amenities.create') }}" class="btn btn-sm btn-primary">
                                            Thêm tiện nghi đầu tiên
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($amenities->hasPages())
                <div class="card-footer bg-white">
                    {{ $amenities->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
