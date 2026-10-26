
@extends('layouts.admin')

@section('title', 'Sửa phòng')
@section('page-heading', 'Sửa phòng')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h4 class="mb-4">Chỉnh sửa phòng {{ $room->room_number }}</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rooms.update', $room->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Số phòng</label>
                    <input type="text" name="room_number"
                           class="form-control"
                           value="{{ old('room_number', $room->room_number) }}"
                           maxlength="10" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại phòng</label>
                    <select name="room_type_id" class="form-select" required>
                        @foreach ($roomTypes as $type)
                            <option value="{{ $type->id }}"
                                @selected(old('room_type_id', $room->room_type_id) == $type->id)>
                                {{ $type->name }}
                                - {{ number_format($type->base_price, 0, ',', '.') }} VNĐ/đêm
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tầng</label>
                    <input type="number" name="floor"
                           class="form-control"
                           min="0" max="255"
                           value="{{ old('floor', $room->floor) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select" required>
                        <option value="available"
                            @selected(old('status', $room->status) === 'available')>
                            Sẵn sàng
                        </option>
                        <option value="occupied"
                            @selected(old('status', $room->status) === 'occupied')>
                            Đang có khách
                        </option>
                        <option value="cleaning"
                            @selected(old('status', $room->status) === 'cleaning')>
                            Đang dọn dẹp
                        </option>
                        <option value="maintenance"
                            @selected(old('status', $room->status) === 'maintenance')>
                            Bảo trì
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control"
                              rows="3">{{ old('note', $room->note) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.rooms.index') }}"
                       class="btn btn-outline-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">
                        Cập nhật phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
