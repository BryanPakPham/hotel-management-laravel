@extends('layouts.customer')

@section('title', 'Chi tiết đặt phòng | Vinpearl')

@section('content')
    <section class="customer-page">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="section-heading">
                <span class="section-eyebrow">BOOKING CONFIRMED</span>
                <h1>Chi tiết đặt phòng</h1>
                <p>Mã đặt phòng <strong>{{ $booking->booking_code }}</strong></p>
            </div>

            <div class="booking-detail-card">
                <div class="booking-detail-card__header">
                    <div>
                        <span class="muted">Trạng thái</span>
                        <span class="status status--{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="booking-total">
                        {{ number_format($booking->total_amount, 0, ',', '.') }} đ
                    </div>
                </div>

                <div class="detail-grid">
                    <div>
                        <span>Khách hàng</span>
                        <strong>{{ $booking->guest_name }}</strong>
                    </div>
                    <div>
                        <span>Liên hệ</span>
                        <strong>{{ $booking->guest_phone }}</strong>
                        <small>{{ $booking->guest_email }}</small>
                    </div>
                    <div>
                        <span>Nhận phòng</span>
                        <strong>{{ $booking->check_in_date->format('d/m/Y') }}</strong>
                    </div>
                    <div>
                        <span>Trả phòng</span>
                        <strong>{{ $booking->check_out_date->format('d/m/Y') }}</strong>
                    </div>
                </div>

                <h2>Phòng đã đặt</h2>

                @foreach ($booking->bookingRooms as $bookingRoom)
                    <div class="reserved-room">
                        <div>
                            <strong>{{ optional($bookingRoom->roomType)->name }}</strong>
                            <span>
                                Phòng {{ optional($bookingRoom->room)->room_number ?: 'Chưa phân số' }}
                            </span>
                        </div>
                        <strong>
                            {{ number_format($bookingRoom->price_per_night, 0, ',', '.') }} đ/đêm
                        </strong>
                    </div>
                @endforeach
            </div>

            <div class="booking-detail-actions">
                <a href="{{ route('customer.bookings.index') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    Về danh sách đặt phòng
                </a>

                @if (in_array($booking->status, ['pending', 'confirmed'], true) && $booking->check_in_date->isFuture())
                    <form
                        method="POST"
                        action="{{ route('customer.bookings.cancel', $booking) }}"
                        onsubmit="return confirm('Bạn có chắc muốn hủy đặt phòng này không?')"
                    >
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-outline-danger" type="submit">
                            Hủy đặt phòng
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>
@endsection
