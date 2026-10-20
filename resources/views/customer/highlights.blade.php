@extends('layouts.customer')
@section('title', 'Điểm nổi bật | Vinpearl')
@section('content')
<section class="customer-page highlights-page">
    <div class="container">
        <div class="section-heading highlights-heading" data-reveal>
            <span class="section-eyebrow">OUR HIGHLIGHTS</span>
            <h1>Điểm nổi bật về khách sạn</h1>
            <p>Không chỉ là nơi nghỉ qua đêm, khách sạn là điểm bắt đầu cho những ngày nghỉ thoải mái, những cuộc gặp gỡ đáng nhớ và hành trình khám phá trọn vẹn.</p>
        </div>

        @if ($featuredRoomType)
            <section class="featured-stay" data-reveal>
                <div class="featured-stay__image">
                    @if ($featuredRoomType->images->first())
                        <img src="{{ asset('storage/' . $featuredRoomType->images->first()->path) }}" alt="{{ $featuredRoomType->name }}">
                    @else
                        <div class="room-card__placeholder"><i class="bi bi-building"></i></div>
                    @endif
                    <span class="featured-stay__badge"><i class="bi bi-fire"></i> Được đặt nhiều nhất</span>
                </div>
                <div class="featured-stay__content">
                    <span class="section-eyebrow">GUEST FAVOURITE</span>
                    <h2>{{ $featuredRoomType->name }}</h2>
                    <p class="featured-stay__lead">Đây là loại phòng được nhiều khách lựa chọn nhất trong hệ thống, nhờ sự cân bằng giữa không gian, tiện nghi và mức giá phù hợp.</p>
                    <p>{{ $featuredRoomType->description }} Dù bạn đi nghỉ cùng gia đình, đi công tác hay cần một nơi yên tĩnh để tái tạo năng lượng, căn phòng mang đến cảm giác dễ chịu ngay từ lúc bước vào.</p>
                    <div class="featured-stay__facts">
                        <span><i class="bi bi-people"></i>{{ $featuredRoomType->max_adults }} người lớn + {{ $featuredRoomType->max_children }} trẻ em</span>
                        <span><i class="bi bi-rulers"></i>{{ $featuredRoomType->area }} m²</span>
                        <span><i class="bi bi-bar-chart-line"></i>{{ $featuredRoomType->bookings_count }} lượt đặt</span>
                    </div>
                    <a href="{{ route('rooms.show', $featuredRoomType) }}" class="btn btn-brand">Xem chi tiết phòng <i class="bi bi-arrow-right"></i></a>
                </div>
            </section>
        @endif

        <section class="hotel-story" data-reveal>
            <div><span class="section-eyebrow">A COMPLETE STAY</span><h2>Một kỳ nghỉ thoải mái bắt đầu từ những điều nhỏ nhất</h2></div>
            <p>Chúng tôi chú trọng từng chi tiết: căn phòng được chuẩn bị sạch sẽ, thông tin được trình bày rõ ràng, quy trình đặt phòng thuận tiện và đội ngũ luôn sẵn sàng hỗ trợ. Từ buổi sáng thong thả với một tách cà phê đến buổi tối trở về trong không gian yên tĩnh, mọi khoảnh khắc đều được tạo ra để bạn nghỉ ngơi đúng nghĩa.</p>
        </section>

        <section class="hotel-values">
            <article data-reveal data-reveal-delay="0"><i class="bi bi-house-heart"></i><h3>Không gian như ở nhà</h3><p>Phòng nghỉ được sắp xếp gọn gàng, ấm cúng và phù hợp với nhiều nhu cầu lưu trú.</p></article>
            <article data-reveal data-reveal-delay="100"><i class="bi bi-clock-history"></i><h3>Phục vụ đúng lúc</h3><p>Thông tin rõ ràng, hỗ trợ nhanh chóng và các lựa chọn được thiết kế để bạn tiết kiệm thời gian.</p></article>
            <article data-reveal data-reveal-delay="200"><i class="bi bi-compass"></i><h3>Gần trải nghiệm địa phương</h3><p>Dễ dàng tìm thấy món ngon, quán cà phê, điểm vui chơi và những nơi đáng khám phá xung quanh.</p></article>
            <article data-reveal data-reveal-delay="300"><i class="bi bi-shield-check"></i><h3>An tâm trong suốt kỳ nghỉ</h3><p>Quy trình đặt phòng và kiểm tra tình trạng phòng giúp hành trình của bạn minh bạch, thuận tiện hơn.</p></article>
        </section>

        <section class="highlight-experiences">
            <div class="section-heading" data-reveal>
                <span class="section-eyebrow">MORE TO DISCOVER</span>
                <h2>Những trải nghiệm làm nên kỳ nghỉ đáng nhớ</h2>
                <p>Mỗi lựa chọn đều được thiết kế để bạn tận hưởng khách sạn theo cách riêng của mình.</p>
            </div>
            <div class="highlight-experience-grid">
                <article data-reveal data-reveal-delay="0"><i class="bi bi-cup-hot"></i><h3>Ẩm thực địa phương</h3><p>Khám phá những món ăn ngon, quán cà phê ấm cúng và hương vị đặc trưng ngay gần nơi lưu trú.</p><a href="{{ route('rooms.index') }}">Khám phá phòng <i class="bi bi-arrow-right"></i></a></article>
                <article data-reveal data-reveal-delay="100"><i class="bi bi-water"></i><h3>Thư giãn trọn vẹn</h3><p>Dành thời gian nghỉ ngơi, đọc sách, thưởng thức đồ uống và nạp lại năng lượng sau mỗi hành trình.</p><a href="{{ route('rooms.index') }}">Chọn không gian nghỉ <i class="bi bi-arrow-right"></i></a></article>
                <article data-reveal data-reveal-delay="200"><i class="bi bi-people"></i><h3>Cho cả gia đình</h3><p>Nhiều loại phòng có sức chứa linh hoạt, giúp chuyến đi cùng người thân thoải mái và gắn kết hơn.</p><a href="{{ route('rooms.index') }}">Tìm phòng gia đình <i class="bi bi-arrow-right"></i></a></article>
                <article data-reveal data-reveal-delay="300"><i class="bi bi-heart"></i><h3>Dịch vụ tận tâm</h3><p>Từ tư vấn trước chuyến đi đến hỗ trợ trong thời gian lưu trú, chúng tôi luôn đặt sự hài lòng của bạn lên trước.</p><a href="{{ route('rooms.index') }}">Bắt đầu hành trình <i class="bi bi-arrow-right"></i></a></article>
            </div>
        </section>

        <section class="popular-room-list" data-reveal>
            <div class="section-heading section-heading--row"><div><span class="section-eyebrow">GUEST CHOICES</span><h2>Các loại phòng được yêu thích</h2></div></div>
            <div class="popular-room-list__grid">
                @foreach ($roomTypes as $roomType)
                    <a href="{{ route('rooms.show', $roomType) }}" class="popular-room-item">
                        <span class="popular-room-item__rank">{{ $loop->iteration }}</span>
                        <span><strong>{{ $roomType->name }}</strong><small>{{ $roomType->bookings_count }} lượt đặt · từ {{ number_format($roomType->base_price, 0, ',', '.') }} đ/đêm</small></span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
</section>
@endsection
