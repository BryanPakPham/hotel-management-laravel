@extends('layouts.customer')

@section('title', 'Danh sách phòng | Vinpearl')

@section('search')
    <form action="{{ route('rooms.index') }}" method="GET" class="booking-form" id="bookingSearchForm">
        <div class="booking-field booking-destination">
            <label for="destination"><i class="bi bi-geo-alt"></i> Điểm đến</label>
            <select name="destination" id="destination" class="form-select">
                <option value="nha-trang" @selected(request('destination', 'nha-trang') === 'nha-trang')>Vinpearl Nha Trang</option>
                <option value="phu-quoc" @selected(request('destination') === 'phu-quoc')>Vinpearl Phú Quốc</option>
                <option value="da-nang" @selected(request('destination') === 'da-nang')>Vinpearl Đà Nẵng</option>
                <option value="nam-hoi-an" @selected(request('destination') === 'nam-hoi-an')>Vinpearl Nam Hội An</option>
            </select>
        </div>

        <div class="booking-field">
            <label for="checkin"><i class="bi bi-calendar-check"></i> Nhận phòng</label>
            <input type="date" name="checkin" id="checkin" class="form-control" value="{{ $checkin }}" required>
        </div>

        <div class="booking-field">
            <label for="checkout"><i class="bi bi-calendar2-check"></i> Trả phòng</label>
            <input type="date" name="checkout" id="checkout" class="form-control" value="{{ $checkout }}" required>
        </div>

        <div class="booking-field booking-guests">
            <label for="adults"><i class="bi bi-people"></i> Người lớn</label>
            <select name="adults" id="adults" class="form-select">
                @for ($count = 1; $count <= 6; $count++)
                    <option value="{{ $count }}" @selected((int) request('adults', 2) === $count)>{{ $count }} người</option>
                @endfor
            </select>
        </div>

        <div class="booking-field booking-guests">
            <label for="children"><i class="bi bi-person-hearts"></i> Trẻ em</label>
            <select name="children" id="children" class="form-select">
                @for ($count = 0; $count <= 4; $count++)
                    <option value="{{ $count }}" @selected((int) request('children', 0) === $count)>{{ $count }} trẻ em</option>
                @endfor
            </select>
        </div>

        <div class="booking-field booking-guests">
            <label for="rooms"><i class="bi bi-door-open"></i> Số phòng</label>
            <select name="rooms" id="rooms" class="form-select">
                @for ($count = 1; $count <= 4; $count++)
                    <option value="{{ $count }}" @selected((int) request('rooms', 1) === $count)>{{ $count }} phòng</option>
                @endfor
            </select>
        </div>

        <div class="booking-submit">
            <button type="submit" class="btn btn-search"><i class="bi bi-search me-2"></i>Tìm phòng</button>
        </div>
        <p class="booking-message" id="bookingMessage" role="alert"></p>
    </form>
@endsection

@section('content')
    <section class="customer-page">
        <div class="container">
            <div class="section-heading section-heading--row">
                <div>
                    <span class="section-eyebrow">AVAILABLE ROOMS</span>
                    <h1>Phòng phù hợp với lịch trình của bạn</h1>
                    <p>{{ \Carbon\Carbon::parse($checkin)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($checkout)->format('d/m/Y') }}</p>
                </div>
                <span class="result-count">{{ $roomTypes->total() }} lựa chọn</span>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="room-grid">
                @forelse ($roomTypes as $roomType)
                    @php($image = $roomType->images->first())
                    <article class="room-card">
                        <a href="{{ route('rooms.show', array_merge([$roomType], request()->only('checkin', 'checkout', 'adults', 'children'))) }}" class="room-card__image">
                            @if ($image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $roomType->name }}">
                            @else
                                <div class="room-card__placeholder"><i class="bi bi-building"></i></div>
                            @endif
                            <span class="room-card__badge">{{ $roomType->available_rooms_count }} phòng trống</span>
                        </a>
                        <div class="room-card__body">
                            <h2><a href="{{ route('rooms.show', $roomType) }}">{{ $roomType->name }}</a></h2>
                            <p>{{ \Illuminate\Support\Str::limit($roomType->description, 120) }}</p>
                            <div class="room-card__meta">
                                <span><i class="bi bi-cash-stack"></i> {{ number_format($roomType->base_price, 0, ',', '.') }} đ/đêm</span>
                                <span><i class="bi bi-people"></i> {{ $roomType->max_adults }} người lớn + {{ $roomType->max_children }} trẻ em</span>
                            </div>
                            <a href="{{ auth()->check() ? route('customer.bookings.create', ['room_type_id' => $roomType->id, 'checkin' => $checkin, 'checkout' => $checkout, 'adults' => request('adults', 2), 'children' => request('children', 0), 'rooms' => request('rooms', 1)]) : url('/login') }}" class="btn btn-brand">Đặt phòng</a>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <h3>Không còn phòng phù hợp</h3>
                        <p>Hãy thử đổi ngày nhận hoặc trả phòng để xem thêm lựa chọn.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-wrap">{{ $roomTypes->links() }}</div>
        </div>
    </section>
@endsection
