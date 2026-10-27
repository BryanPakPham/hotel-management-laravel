@extends('layouts.customer')

@section('title', 'Tài khoản cá nhân | Vinpearl')

@section('content')
<section class="customer-page customer-account-page">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">MY ACCOUNT</span>
            <h1>Thông tin cá nhân</h1>
            <p>Cập nhật thông tin để việc xác nhận đặt phòng thuận tiện hơn.</p>
        </div>

        <div class="account-layout">
            <aside class="account-card account-card--profile">
                <div class="account-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <span class="account-badge"><i class="bi bi-person-check"></i> Khách hàng</span>
                <a href="{{ route('customer.bookings.index') }}" class="account-link">Xem đặt phòng <i class="bi bi-arrow-right"></i></a>
            </aside>

            <div class="account-card">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
                @endif
                <form method="POST" action="{{ route('customer.account.update') }}" class="customer-form">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <div class="form-grid__full">
                            <label for="name">Họ và tên</label>
                            <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div>
                            <label for="phone">Số điện thoại</label>
                            <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div>
                            <label>Email</label>
                            <input value="{{ $user->email }}" disabled>
                        </div>
                        <div class="form-grid__full">
                            <label for="address">Địa chỉ</label>
                            <input id="address" name="address" value="{{ old('address', $user->address) }}">
                        </div>
                    </div>
                    <button class="btn btn-brand" type="submit">Lưu thay đổi <i class="bi bi-check2"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
