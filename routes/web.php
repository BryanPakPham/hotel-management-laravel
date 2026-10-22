
<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\RoomController;
use App\Http\Controllers\Receptionist\BookingController as ReceptionistBookingController;
use App\Http\Controllers\Receptionist\StayController as ReceptionistStayController;
use App\Http\Controllers\Receptionist\ServiceController as ReceptionistServiceController;

// Trang chủ và phòng có thể xem trước khi đăng nhập.
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/highlights', [HomeController::class, 'highlights'])->name('highlights');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{roomType:slug}', [RoomController::class, 'show'])->name('rooms.show');

// Khu vực Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
    });

// Khu vực Lễ tân
Route::middleware(['auth', 'role:receptionist'])
    ->prefix('receptionist')
    ->name('receptionist.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('receptionist.dashboard');
        })->name('dashboard');

        Route::get('/bookings', [
            ReceptionistBookingController::class,
            'index'
        ])->name('bookings.index');

        Route::get('/bookings/{id}', [
            ReceptionistBookingController::class,
            'show'
        ])->name('bookings.show');

        Route::post('/bookings/{id}/confirm', [
            ReceptionistBookingController::class,
            'confirm'
        ])->name('bookings.confirm');

        Route::get('/stays', [ReceptionistStayController::class, 'index'])
            ->name('stays.index');

        Route::post('/stays/{id}/check-in', [ReceptionistStayController::class, 'checkIn'])
            ->name('stays.checkIn');

        Route::post('/stays/{id}/check-out', [ReceptionistStayController::class, 'checkOut'])
            ->name('stays.checkOut');

        Route::get('/services', [ReceptionistServiceController::class, 'index'])
            ->name('services.index');

        Route::get('/services', [
            ReceptionistServiceController::class,
            'index'
        ])->name('services.index');

        Route::post('/services', [
            ReceptionistServiceController::class,
            'store'
        ])->name('services.store');
    });

// Khu vực Khách hàng
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');

        Route::get('/bookings', [BookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/create', [BookingController::class, 'create'])
            ->name('bookings.create');

        Route::post('/bookings', [BookingController::class, 'store'])
            ->name('bookings.store');

        Route::get('/bookings/{booking}', [BookingController::class, 'show'])
            ->name('bookings.show');
    });
