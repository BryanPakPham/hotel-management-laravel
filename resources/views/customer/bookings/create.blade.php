@extends('layouts.customer')
@section('title', 'Xác nhận đặt phòng | Vinpearl')

@php
    $checkinDate = \Carbon\Carbon::parse($validated['checkin']);
    $checkoutDate = \Carbon\Carbon::parse($validated['checkout']);
    $nights = max(1, $checkinDate->diffInDays($checkoutDate));
    $totalAmount = $nights * (float) $roomType->base_price;
@endphp

@section('content')
<section class="customer-page">
    <div class="container">
        <a href="{{ route('rooms.show', [$roomType, 'checkin' => $validated['checkin'], 'checkout' => $validated['checkout']]) }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Quay lại phòng
        </a>

        <div class="booking-layout">
            <div class="booking-form-card">
                <span class="section-eyebrow">FINAL STEP</span>
                <h1>Hoàn tất đặt phòng</h1>
                <p class="muted">Điền thông tin để chúng tôi xác nhận kỳ nghỉ của bạn.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.bookings.store') }}" method="POST" class="customer-form">
                    @csrf
                    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                    <input type="hidden" name="checkin" value="{{ $validated['checkin'] }}">
                    <input type="hidden" name="checkout" value="{{ $validated['checkout'] }}">
                    <input type="hidden" name="adults" value="{{ $validated['adults'] }}">
                    <input type="hidden" name="children" value="{{ $validated['children'] ?? 0 }}">

                    <div class="form-section">
                        <h2>Thông tin khách hàng</h2>
                        <div class="form-grid">
                            <div>
                                <label for="guest_name">Họ và tên</label>
                                <input id="guest_name" name="guest_name" value="{{ old('guest_name', auth()->user()->name) }}" required>
                            </div>
                            <div>
                                <label for="guest_phone">Số điện thoại</label>
                                <input id="guest_phone" name="guest_phone" value="{{ old('guest_phone', auth()->user()->phone) }}" required>
                            </div>
                            <div class="form-grid__full">
                                <label for="guest_email">Email</label>
                                <input type="email" id="guest_email" name="guest_email" value="{{ old('guest_email', auth()->user()->email) }}" required>
                            </div>
                            <div class="form-grid__full">
                                <label for="note">Ghi chú (không bắt buộc)</label>
                                <textarea id="note" name="note" rows="3">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-brand btn-lg w-100" type="submit">
                        Xác nhận đặt phòng <i class="bi bi-check2"></i>
                    </button>
                </form>
            </div>

            <aside class="booking-summary">
                <h2>{{ $roomType->name }}</h2>
                <div class="summary-row">
                    <span>Nhận phòng</span>
                    <strong>{{ $checkinDate->format('d/m/Y') }}</strong>
                </div>
                <div class="summary-row">
                    <span>Trả phòng</span>
                    <strong>{{ $checkoutDate->format('d/m/Y') }}</strong>
                </div>
                <div class="summary-row">
                    <span>Số đêm nghỉ</span>
                    <strong>{{ $nights }} đêm</strong>
                </div>
                <div class="summary-row">
                    <span>Số lượng khách</span>
                    <strong>{{ $validated['adults'] }} người lớn, {{ $validated['children'] ?? 0 }} trẻ em</strong>
                </div>
                <div class="summary-row">
                    <span>Đơn giá</span>
                    <strong>{{ number_format($roomType->base_price, 0, ',', '.') }} đ/đêm</strong>
                </div>

                <hr style="margin: 16px 0; border: none; border-top: 1px dashed rgba(18, 48, 74, 0.15);">

                <div class="summary-row summary-total" style="align-items: baseline;">
                    <span style="font-size: 16px; font-weight: 700; color: var(--navy);">Tổng thanh toán</span>
                    <strong style="font-size: 22px; color: #a77a3b;">{{ number_format($totalAmount, 0, ',', '.') }} đ</strong>
                </div>

                <div style="margin-top: 12px; font-size: 13px; color: #6f7c85;">
                    <i class="bi bi-door-open me-1"></i> Còn {{ $availableRooms->count() }} phòng trống
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
