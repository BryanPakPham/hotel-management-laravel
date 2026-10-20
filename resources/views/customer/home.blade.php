@extends('layouts.customer')
@section('title', 'Trang chủ | Vinpearl')
@section('content')
<section class="customer-page customer-home">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">STAY YOUR WAY</span>
            <h2>Không gian nghỉ dưỡng dành riêng cho bạn</h2>
            <p>Chọn căn phòng phù hợp và bắt đầu hành trình thư giãn đáng nhớ.</p>
        </div>
        <div class="room-grid">
            @forelse ($roomTypes as $roomType)
                @php($image = $roomType->images->first())
                <article class="room-card">
                    <a href="{{ route('rooms.show', $roomType) }}" class="room-card__image">
                        @if ($image)
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $roomType->name }}">
                        @else
                            <div class="room-card__placeholder"><i class="bi bi-building"></i></div>
                        @endif
                        <span class="room-card__badge">Từ {{ number_format($roomType->base_price, 0, ',', '.') }} đ</span>
                    </a>
                    <div class="room-card__body">
                        <h3><a href="{{ route('rooms.show', $roomType) }}">{{ $roomType->name }}</a></h3>
                        <p>{{ \Illuminate\Support\Str::limit($roomType->description, 110) }}</p>
                        <div class="room-card__meta">
                            <span><i class="bi bi-rulers"></i> {{ $roomType->area }} m²</span>
                            <span><i class="bi bi-people"></i> {{ $roomType->max_adults }} người lớn + {{ $roomType->max_children }} trẻ em</span>
                        </div>
                        <a href="{{ route('rooms.show', $roomType) }}" class="btn btn-outline-brand">Xem chi tiết <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>
            @empty
                <div class="empty-state"><i class="bi bi-house-exclamation"></i><h3>Chưa có phòng</h3><p>Thông tin phòng đang được cập nhật.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
