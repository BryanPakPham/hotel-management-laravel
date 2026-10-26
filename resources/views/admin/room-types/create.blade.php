
@extends('layouts.admin')

@section('title', 'Thêm loại phòng')
@section('page-heading', 'Thêm loại phòng')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h4 class="mb-4">Thêm loại phòng mới</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.room-types.store') }}"
                  method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tên loại phòng</label>
                    <input type="text" name="name"
                           class="form-control"
                           value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá cơ bản mỗi đêm (VNĐ)</label>
                    <input type="number" name="base_price"
                           class="form-control"
                           min="0" step="0.01"
                           value="{{ old('base_price') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số người lớn tối đa</label>
                        <input type="number" name="max_adults"
                               class="form-control"
                               min="1" max="255"
                               value="{{ old('max_adults', 2) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số trẻ em tối đa</label>
                        <input type="number" name="max_children"
                               class="form-control"
                               min="0" max="255"
                               value="{{ old('max_children', 0) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại giường</label>
                    <input type="text" name="bed_type"
                           class="form-control"
                           value="{{ old('bed_type') }}"
                           placeholder="Ví dụ: 1 giường đôi" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diện tích (m²)</label>
                    <input type="number" name="area"
                           class="form-control"
                           min="0.01" max="9999.99" step="0.01"
                           value="{{ old('area') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control"
                              rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.room-types.index') }}"
                       class="btn btn-outline-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">
                        Lưu loại phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
