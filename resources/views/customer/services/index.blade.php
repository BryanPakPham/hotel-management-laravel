@extends('layouts.customer')

@section('title', 'Dịch vụ khách sạn | Vinpearl')

@section('content')
<section class="customer-page customer-service-page">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">HOTEL SERVICES</span>
            <h1>Những trải nghiệm dành riêng cho bạn</h1>
            <p>Tận hưởng kỳ nghỉ trọn vẹn với các dịch vụ được chuẩn bị chu đáo trong từng chi tiết.</p>
        </div>

        <div class="service-grid">
            @forelse ($services as $service)
                <article class="service-card">
                    <div class="service-card__icon"><i class="bi bi-stars"></i></div>
                    <div>
                        <h2>{{ $service->name }}</h2>
                        <p>{{ $service->description ?: 'Dịch vụ được phục vụ tận tâm theo nhu cầu của bạn.' }}</p>
                        <strong>{{ number_format($service->price, 0, ',', '.') }} đ <small>/ {{ $service->unit ?: 'lần' }}</small></strong>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <i class="bi bi-stars"></i>
                    <h3>Dịch vụ đang được cập nhật</h3>
                    <p>Vui lòng quay lại sau để khám phá thêm trải nghiệm tại khách sạn.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
