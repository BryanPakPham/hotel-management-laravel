
<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\RoomController;
use Illuminate\Support\Facades\Route;

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
    });

// Khu vực Khách hàng
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    });
