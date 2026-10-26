
@extends('layouts.admin')

@section('title', 'Sửa khách hàng')
@section('page-heading', 'Sửa khách hàng')

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Sửa thông tin khách hàng</h2>
        <p class="text-secondary mb-0">
            Cập nhật thông tin tài khoản khách hàng.
        </p>
    </div>

    {{-- Hiển thị lỗi xác thực --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('admin.users.update', $user->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Họ tên --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Họ và tên <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            required
                        >
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            required
                        >
                    </div>

                    {{-- Số điện thoại --}}
                    <div class="col-md-6">
                        <label for="phone" class="form-label">
                            Số điện thoại
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $user->phone) }}"
                        >
                    </div>

                    {{-- CCCD --}}
                    <div class="col-md-6">
                        <label for="id_number" class="form-label">
                            Số CCCD
                        </label>

                        <input
                            type="text"
                            id="id_number"
                            name="id_number"
                            class="form-control"
                            value="{{ old('id_number', $user->id_number) }}"
                        >
                    </div>

                    {{-- Địa chỉ --}}
                    <div class="col-12">
                        <label for="address" class="form-label">
                            Địa chỉ
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            class="form-control"
                            rows="3"
                        >{{ old('address', $user->address) }}</textarea>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="col-md-6">
                        <label for="is_active" class="form-label">
                            Trạng thái tài khoản
                        </label>

                        <select
                            id="is_active"
                            name="is_active"
                            class="form-select"
                            required
                        >
                            <option value="1"
                                @selected((string) old('is_active', $user->is_active) === '1')>
                                Đang hoạt động
                            </option>

                            <option value="0"
                                @selected((string) old('is_active', $user->is_active) === '0')>
                                Ngừng hoạt động
                            </option>
                        </select>
                    </div>

                </div>

                {{-- Nút thao tác --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        Lưu thay đổi
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-secondary">
                        Quay lại
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
