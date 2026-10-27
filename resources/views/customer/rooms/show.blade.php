@extends('layouts.customer')
@section('title', $roomType->name . ' | Vinpearl')
@section('content')
<section class="customer-page room-detail-page">
    <div class="container">
        <a href="{{ route('rooms.index', ['checkin' => $checkin, 'checkout' => $checkout]) }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách phòng
        </a>

        <div class="room-detail__top">
            <div class="room-detail__gallery">
                <div class="room-detail__gallery-grid">
                    @for ($imageIndex = 0; $imageIndex < 4; $imageIndex++)
                        @php($image=$roomType->images->get($imageIndex))
                        <button type="button" class="room-detail__gallery-item {{ $imageIndex === 0 ? 'room-detail__gallery-item--large' : '' }}" data-room-image="{{ $image ? asset('storage/' . $image->path) : '' }}" data-room-index="{{ $image ? $imageIndex : '' }}" aria-label="Xem ảnh {{ $imageIndex + 1 }}">
                            @if ($image)
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $roomType->name }} - ảnh {{ $imageIndex + 1 }}">
                            @else
                            <span class="room-card__placeholder"><i class="bi bi-building"></i></span>
                            @endif
                            @if ($imageIndex === 3 && $roomType->images->count() > 4)
                            <span class="room-detail__more-images">+{{ $roomType->images->count() - 4 }} ảnh</span>
                            @endif
                        </button>
                        @endfor
                </div>
                @if ($roomType->images->isNotEmpty())
                <div class="room-detail__thumbnails" aria-label="Thư viện ảnh {{ $roomType->name }}">
                    @foreach ($roomType->images as $image)
                    <button type="button" class="room-detail__thumbnail {{ $loop->first ? 'is-active' : '' }}" data-room-image="{{ asset('storage/' . $image->path) }}" data-room-index="{{ $loop->index }}" aria-label="Xem ảnh {{ $loop->iteration }}">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $roomType->name }} - ảnh {{ $loop->iteration }}">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
            @if ($roomType->images->isNotEmpty())
            <div class="room-lightbox" id="roomLightbox" hidden role="dialog" aria-modal="true" aria-label="Thư viện ảnh {{ $roomType->name }}">
                <button type="button" class="room-lightbox__close" id="roomLightboxClose" aria-label="Đóng thư viện ảnh"><i class="bi bi-x-lg"></i></button>
                <button type="button" class="room-lightbox__arrow room-lightbox__arrow--prev" id="roomLightboxPrev" aria-label="Ảnh trước"><i class="bi bi-chevron-left"></i></button>
                <div class="room-lightbox__content">
                    <img id="roomLightboxImage" src="{{ asset('storage/' . $roomType->images->first()->path) }}" alt="{{ $roomType->name }}">
                    <span class="room-lightbox__counter" id="roomLightboxCounter">1 / {{ $roomType->images->count() }}</span>
                </div>
                <button type="button" class="room-lightbox__arrow room-lightbox__arrow--next" id="roomLightboxNext" aria-label="Ảnh tiếp theo"><i class="bi bi-chevron-right"></i></button>
            </div>
            @endif

            <div class="room-detail__content">
                <span class="section-eyebrow">ROOM DETAIL</span>
                <h1>{{ $roomType->name }}</h1>
                <p class="room-detail__price">{{ number_format($roomType->base_price, 0, ',', '.') }} đ <small>/ đêm</small></p>
                <p class="room-detail__description">{{ $roomType->description }}</p>

                <div class="room-detail__facts">
                    <span><i class="bi bi-rulers"></i>{{ $roomType->area }} m²</span>
                    <span><i class="bi bi-people"></i>{{ $roomType->max_adults }} người lớn</span>
                    <span><i class="bi bi-person-hearts"></i>{{ $roomType->max_children }} trẻ em</span>
                    <span><i class="bi bi-lamp"></i>{{ $roomType->bed_type }}</span>
                </div>

                @if ($roomType->rooms->isNotEmpty())
                <div class="room-detail__availability">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Còn <strong>{{ $roomType->rooms->count() }} phòng</strong> phù hợp với ngày bạn chọn.</span>
                </div>
                <a href="{{ auth()->check() ? route('customer.bookings.create', ['room_type_id' => $roomType->id, 'checkin' => $checkin, 'checkout' => $checkout, 'adults' => request('adults', 2), 'children' => request('children', 0)]) : url('/login') }}" class="btn btn-brand btn-lg room-detail__action">
                    Đặt phòng ngay <i class="bi bi-arrow-right"></i>
                </a>
                @else
                <div class="alert alert-warning">Phòng này hiện không còn trống trong khoảng thời gian đã chọn.</div>
                @endif
            </div>
        </div>

        <section class="room-detail__highlights">
            <h2>Điểm nổi bật của phòng</h2>
            <div class="room-highlight-grid">
                <div><i class="bi bi-wifi"></i><span><strong>Wi-Fi miễn phí</strong><small>Kết nối ổn định trong phòng</small></span></div>
                <div><i class="bi bi-shield-check"></i><span><strong>Không gian riêng tư</strong><small>Phù hợp nghỉ dưỡng và công tác</small></span></div>
                <div><i class="bi bi-cup-hot"></i><span><strong>Dịch vụ chu đáo</strong><small>Hỗ trợ nhanh chóng 24/7</small></span></div>
            </div>
        </section>

        <section class="room-detail__description-block">
            <div>
                <span class="section-eyebrow">ABOUT THIS ROOM</span>
                <h2>Thông tin về {{ $roomType->name }}</h2>
                <p>{{ $roomType->description }} Đây là lựa chọn phù hợp cho những ngày nghỉ cần sự thoải mái, tiện nghi và thuận tiện di chuyển. Không gian được sắp xếp để bạn có thể nghỉ ngơi, làm việc hoặc tận hưởng thời gian bên gia đình.</p>
            </div>
            <aside>
                <i class="bi bi-geo-alt"></i>
                <strong>Vị trí thuận tiện</strong>
                <span>Dễ dàng kết nối với các điểm ăn uống, mua sắm và tham quan nổi bật.</span>
            </aside>
        </section>

        <section class="room-detail__amenities">
            <h2>Các tiện nghi được ưa chuộng</h2>
            <div class="room-amenity-row">
                @forelse ($roomType->amenities as $amenity)
                <span><i class="{{ $amenity->icon ?: 'bi bi-check2-circle' }}"></i>{{ $amenity->name }}</span>
                @empty
                <span><i class="bi bi-check2-circle"></i>Đang cập nhật tiện nghi</span>
                @endforelse
                @foreach ($roomServices as $service)
                <span><i class="bi {{ $service['icon'] }}"></i>{{ $service['label'] }}</span>
                @endforeach
            </div>
        </section>

        <section class="room-detail__nearby">
            <h2>Xung quanh khách sạn</h2>
            <p class="room-detail__nearby-intro">Những lựa chọn ăn uống, vui chơi và tham quan thuận tiện cho kỳ nghỉ của bạn.</p>
            <div class="room-nearby-columns">
                <div>
                    <h3><i class="bi bi-person-walking"></i> Xung quanh có gì?</h3>
                    @foreach (array_slice($nearbyPlaces, 0, 2) as $place)
                    <p><span>{{ $place['title'] }}</span><small>{{ $loop->iteration + 1 }} phút đi bộ</small></p>
                    @endforeach
                </div>
                <div>
                    <h3><i class="bi bi-cup-straw"></i> Nhà hàng & quán cà phê</h3>
                    <p><span>Nhà hàng địa phương</span><small>200 m</small></p>
                    <p><span>Cafe & quầy bar</span><small>350 m</small></p>
                    <p><span>Đặc sản địa phương</span><small>500 m</small></p>
                </div>
                <div>
                    <h3><i class="bi bi-image"></i> Điểm tham quan nổi bật</h3>
                    @foreach (array_slice($nearbyPlaces, 2) as $place)
                    <p><span>{{ $place['title'] }}</span><small>{{ $loop->iteration + 2 }} km</small></p>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="room-detail__policies">
            <div>
                <span class="section-eyebrow">GOOD TO KNOW</span>
                <h2>Thông tin quan trọng</h2>
            </div>
            <div class="policy-list">
                @foreach ($policies as $policy)
                <div class="policy-item">
                    <h3>{{ $policy['title'] }}</h3>
                    <p>{{ $policy['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection