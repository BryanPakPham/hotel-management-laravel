@extends('layouts.admin')

@section('title', 'Thêm tiện nghi')
@section('page-heading', 'Thêm tiện nghi')

@section('content')
    <div class="container-fluid px-0">

        <div class="mb-4">
            <h4 class="fw-bold mb-1">Thêm tiện nghi</h4>
            <p class="text-secondary mb-0">
                Nhập thông tin tiện nghi của khách sạn.
            </p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <form action="{{ route('admin.amenities.store') }}" method="POST">
                    @csrf

                    {{-- Tên tiện nghi --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Tên tiện nghi <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="Ví dụ: Wifi miễn phí" required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mô tả --}}
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">
                            Mô tả
                        </label>

                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Nhập mô tả tiện nghi...">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nút thao tác --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Thêm tiện nghi
                        </button>

                        <a href="{{ route('admin.amenities.index') }}" class="btn btn-outline-secondary">
                            Quay lại
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
