
@extends('layouts.admin')

@section('title', 'Sửa loại phòng')
@section('page-heading', 'Sửa loại phòng')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h4 class="mb-4">Chỉnh sửa loại phòng</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.room-types.update', $roomType->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tên loại phòng</label>
                    <input type="text" name="name"
                           class="form-control"
                           value="{{ old('name', $roomType->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá cơ bản mỗi đêm (VNĐ)</label>
                    <input type="number" name="base_price"
                           class="form-control"
                           min="0" step="0.01"
                           value="{{ old('base_price', $roomType->base_price) }}"
                           required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số người lớn tối đa</label>
                        <input type="number" name="max_adults"
                               class="form-control"
                               min="1" max="255"
                               value="{{ old('max_adults', $roomType->max_adults) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số trẻ em tối đa</label>
                        <input type="number" name="max_children"
                               class="form-control"
                               min="0" max="255"
                               value="{{ old('max_children', $roomType->max_children) }}"
                               required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại giường</label>
                    <input type="text" name="bed_type"
                           class="form-control"
                           value="{{ old('bed_type', $roomType->bed_type) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diện tích (m²)</label>
                    <input type="number" name="area"
                           class="form-control"
                           min="0.01" max="9999.99" step="0.01"
                           value="{{ old('area', $roomType->area) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control"
                              rows="4">{{ old('description', $roomType->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.room-types.index') }}"
                       class="btn btn-outline-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
