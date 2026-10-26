
@extends('layouts.admin')

@section('title', 'Thêm phòng')
@section('page-heading', 'Thêm phòng')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h4 class="mb-4">Thêm phòng mới</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Số phòng</label>
                    <input type="text" name="room_number"
                           class="form-control"
                           value="{{ old('room_number') }}"
                           maxlength="10" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại phòng</label>
                    <select name="room_type_id" class="form-select" required>
                        <option value="">-- Chọn loại phòng --</option>
                        @foreach ($roomTypes as $type)
                            <option value="{{ $type->id }}"
                                @selected(old('room_type_id') == $type->id)>
                                {{ $type->name }}
                                - {{ number_format($type->base_price, 0, ',', '.') }} VNĐ/đêm
                            </option>
                        @endforeach
                    </select>
                    @if ($roomTypes->isEmpty())
                        <div class="form-text text-danger">
                            Chưa có loại phòng. Hãy tạo loại phòng trước.
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Tầng</label>
                    <input type="number" name="floor"
                           class="form-control"
                           min="0" max="255"
                           value="{{ old('floor', 1) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select" required>
                        <option value="available"
                            @selected(old('status', 'available') === 'available')>
                            Sẵn sàng
                        </option>
                        <option value="occupied"
                            @selected(old('status') === 'occupied')>
                            Đang có khách
                        </option>
                        <option value="cleaning"
                            @selected(old('status') === 'cleaning')>
                            Đang dọn dẹp
                        </option>
                        <option value="maintenance"
                            @selected(old('status') === 'maintenance')>
                            Bảo trì
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control"
                              rows="3">{{ old('note') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.rooms.index') }}"
                       class="btn btn-outline-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary"
                        @disabled($roomTypes->isEmpty())>
                        Lưu phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
